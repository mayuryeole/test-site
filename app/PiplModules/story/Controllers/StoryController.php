<?php

namespace App\PiplModules\story\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use Datatables;
use App\PiplModules\story\Models\Story;
use App\PiplModules\story\Models\StoryCategory;
use App\PiplModules\story\Models\StoryCategoryTranslation;
use App\PiplModules\story\Models\StoryComment;
use Mail;
use Image;

class StoryController extends Controller {

    private $thumbnail_size = array("width" => 50, "height" => 50);

    public function index() {

        $all_posts = Story::translatedIn(\App::getLocale())->get();

        return view("story::list", array("posts" => $all_posts));
    }

    public function getBlogData() {
        $all_posts = Story::translatedIn(\App::getLocale())->get();
        $all_posts = $all_posts->sortByDesc('id');
        return Datatables::of($all_posts)
                        ->addColumn("category", function($post) {
                            if ($post->category) {
                                return $post->category->name;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('Language', function($post) {
                            $language = '<button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="langDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Another Language <span class="caret"></span> </button>
                         <ul class="dropdown-menu multilanguage" aria-labelledby="langDropDown">';
                            if (count(config("translatable.locales_to_display"))) {
                                foreach (config("translatable.locales_to_display") as $locale => $locale_full_name) {
                                    if ($locale != 'en') {
                                        $language .= '<li class="dropdown-item"> <a href="story-post/' . $post->id . '/' . $locale . '">' . $locale_full_name . '</a></li>';
                                    }
                                }
                            }
                            return $language;
                        })
                        ->make(true);
    }

    public function deleteBlogPost($post_id) {
        $post = Story::find($post_id);

        if ($post) {

            // remove photo and attachments
            $photo = $post->story_image;
            $attachments = $post->story_attachments;

            if ($photo) {

                $this->removeBlogFileFromStrorage($photo);
            }

            foreach ($attachments as $attachment) {
                $this->removeBlogFileFromStrorage($attachment['original_name']);
            }

            $post->delete();

            return redirect("admin/story")->with('status', 'Story post deleted successfully!');
        } else {
            return redirect('admin/story');
        }
    }

    public function deleteSelectedBlogPost($post_id) {
        $post = Story::find($post_id);

        if ($post) {
            // remove photo and attachments
            $photo = $post->story_image;
            $attachments = $post->story_attachments;

            if ($photo) {

                $this->removeBlogFileFromStrorage($photo);
            }

            foreach ($attachments as $attachment) {
                $this->removeBlogFileFromStrorage($attachment['original_name']);
            }

            $post->delete();

            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function removeAttachment(Request $request, $post_id = "", $original_name = "") {
        $post = Story::find($post_id);
        $copyArr = $post->story_attachments;
        $key = array_search($original_name, array_column($copyArr, 'original_name'));
        unset($copyArr[$key]);
        $post->story_attachments = $copyArr;
        $post->save();
        return redirect('admin/story-post/'.$post_id)->with('status', 'Image deleted successfully!');
    }

    public function updateBlogPost(Request $request, $post_id, $locale = "") {
        $post = Story::find($post_id);

        if ($post) {
            $translated_post = $post->translateOrNew($locale);
            if ($request->method() == "GET") {
                if (isset($locale) && $locale != 'en' && $locale != '') {

                    return view('story::update-language', array('post' => $translated_post, 'ori_post' => $post)
                    );
                } else {
                    return view('story::update', array('post' => $translated_post, 'locale' => $locale, 'ori_post' => $post
                            )
                    );
                }
            } else {

                // do validation and update the faq

                $data = $request->all();

                if (!empty($request->url))
                // $data['url'] = str_slug($request->url);
                    if ($locale != 'en' && $locale != '') {
                        $validator_array = array(
                            'title' => 'required',
                            'short_description' => 'required',
                            'description' => 'required',
//                        'seo_title' => 'required',
//                        'seo_keywords' => 'required',
//                        'seo_description' => 'required',
                            'description' => 'min:50|max:300',
                        );
                    } else
                        $validator_array = array(
                            'title' => 'required',
                            'short_description' => 'required',
                            'description' => 'required',
                            'photo' => 'sometimes|image',
//                        'seo_title' => 'required',
//                        'seo_keywords' => 'required',
//                        'seo_description' => 'required',
                            'description' => 'min:50|max:300',
                        );

                if ($locale == "") {
                    $validator_array['url'] = 'required|unique:stories,story_url,' . $post->id;
                }

                $validate_response = Validator::make($data, $validator_array);
                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {

                    if ($locale != "" && $locale != 'en') {
                        $translated_post->story_id = $post_id;
                        $translated_post->locale = $locale;
                        $translated_post->title = $request->title;
                        $translated_post->short_description = $request->short_description;
//                        $translated_post->seo_title = $request->seo_title;
//                        $translated_post->seo_keywords = $request->seo_keywords;
//                        $translated_post->seo_description = $request->seo_description;
                        $translated_post->save();
                    } else {
                        $post->story_url = $request->url;
                        // $post->post_url = str_slug($request->url);

                        if ($request->category) {
                            $post->story_category_id = $request->category;
                        }

                        $post->allow_comments = $request->allow_comments;
                        $post->allow_attachments_in_comments = isset($request->allow_attachments_in_comments) ? $request->allow_attachments_in_comments : '0';
                        $post->story_status = $request->story_status;

                        // check if photo available

                        if (!is_dir(storage_path('app/public/story/thumbnails/'))) {

                            Storage::makeDirectory('public/story/thumbnails/');
                        }

                        if ($request->hasFile('photo')) {
                            $extension = $request->file('photo')->getClientOriginalExtension();

                            $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                            Storage::put('public/story/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));

                            if ($post->story_image) {
                                // delete previous file
                                $this->removeBlogFileFromStrorage($post->story_image);
                            }


                            // make thumbnail

                            $thumbnail = Image::make(storage_path('app/public/story/' . $new_file_name));

                            $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);

                            $thumbnail->save(storage_path('app/public/story/thumbnails/' . $new_file_name));


                            $post->story_image = $new_file_name;
                        }

                        // check attachments available
                        $attachments = array();
                        if ($request->hasFile('attachments')) {
                            $uploaded_files = $request->file('attachments');

                            foreach ($uploaded_files as $uploaded_file) {
                                $extension = $uploaded_file->getClientOriginalExtension();

                                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                                Storage::put('public/story/attachments/' . $new_file_name, file_get_contents($uploaded_file->getRealPath()));

                                $attachments[] = array("original_name" => $new_file_name, "display_name" => $uploaded_file->getClientOriginalName());
                            }
                        }

                        if (count($attachments)) {
                            $prev_attachments = $post->story_attachments;

                            $attachments = array_merge($prev_attachments, $attachments);

                            $post->story_attachments = $attachments;
                        }



                        $post->save();
                    }


                    $translated_post->title = $request->title;
                    $translated_post->short_description = $request->short_description;
                    $translated_post->description = $request->description;
//                    $translated_post->seo_title = $request->seo_title;
//                    $translated_post->seo_keywords = $request->seo_keywords;
//                    $translated_post->seo_description = $request->seo_description;
                    $translated_post->save();
                    return redirect('admin/story')->with('status', 'Story post updated successfully!');
                }
            }
        } else {
            return redirect('admin/story');
        }
    }

    public function createBlogPost(Request $request) {

        if ($request->method() == "GET") {

//            $existing_categories = StoryCategory::withTranslation()->get();
//            $tree = $this->getCategoryTree($existing_categories->toTree(), '&nbsp;&nbsp;');

            return view("story::create");
        } else {
            $data = $request->all();

//            if (!empty($request->url))
//               $data['url'] = str_slug($request->url);

            $validate_response = Validator::make($data, array(
                        'title' => 'required',
                        'short_description' => 'required',
                        'description' => 'required|min:50|max:300',
                        'url' => 'required',
//                         'url' => 'required|unique:posts,post_url',
                        'photo' => 'required|image',
                        'allow_comments' => 'required',
//                        'seo_title' => 'required',
//                        'seo_keywords' => 'required',
//                        'seo_description' => 'required',
                        'story_status' => 'required',
                            ), array(
                            )
            );

            /* @var $validate_response type */
            if ($validate_response->fails()) {

                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {

                $post_attributes = array(
                    'created_by' => Auth::user()->id,
//                     'post_url' => str_slug($request->url),
                    'story_url' => $request->url,
                    'allow_comments' => $request->allow_comments,
                    'allow_attachments_in_comments' => isset($request->allow_attachments_in_comments) ? $request->allow_attachments_in_comments : '0',
                    'story_status' => intval($request->post_status)
                );

//                if ($request->category) {
//                    $post_attributes['story_category_id'] = $request->category;
//                }
                // check if photo available

                if ($request->hasFile('photo')) {
                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                    Storage::put('public/story/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));


                    // make thumbnail

                    $thumbnail = Image::make(storage_path('app/public/story/' . $new_file_name));

                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);

                    $thumbnail->save(storage_path('app/public/story/thumbnails/' . $new_file_name));


                    $post_attributes['story_image'] = $new_file_name;
                }

                // check attachments available
                $attachments = array();
                if ($request->hasFile('attachments')) {
                    $uploaded_files = $request->file('attachments');

                    foreach ($uploaded_files as $uploaded_file) {
                        $extension = $uploaded_file->getClientOriginalExtension();

                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                        Storage::put('public/story/attachments/' . $new_file_name, file_get_contents($uploaded_file->getRealPath()));

                        $attachments[] = array("original_name" => $new_file_name, "display_name" => $uploaded_file->getClientOriginalName());
                    }
                }

                $post_attributes['story_attachments'] = $attachments;

                $created_post = Story::create($post_attributes);




                $translated_post = $created_post->translateOrNew(\App::getLocale());
                $translated_post->title = $request->title;
                $translated_post->short_description = $request->short_description;
                $translated_post->description = $request->description;
//                $translated_post->seo_title = $request->seo_title;
//                $translated_post->seo_keywords = $request->seo_keywords;
//                $translated_post->seo_description = $request->seo_description;
                $translated_post->locale = \App:: getLocale();
                $translated_post->story_id = $created_post->id;
                $translated_post->save();
                return redirect("admin/story")->with('status', 'Story created successfully!');
            }
        }
    }

    public function removePostPhoto($post_id) {
        $post = Story::find($post_id);

        if ($post) {
            $post_image = $post->story_image;

            if ($post_image) {
                if ($this->removeBlogFileFromStrorage($post_image)) {
                    $post->story_image = "";
                    $post->save();
                }
            }
        }

        echo '<script>window.opener.alert("File deleted successfully!");window.opener.location.reload();window.opener = window.self;window.close();</script>';
    }

    public function removePostAttachment($post_id, $attachment_id) {
        $post = Story::find($post_id);

        if ($post) {
            $post_attachments = $post->story_attachments;

            $attachment_to_remove = $post_attachments[$attachment_id];

            if ($attachment_to_remove) {
                if ($this->removeBlogFileFromStrorage($attachment_to_remove['original_name'])) {
                    array_forget($post_attachments, '' . $attachment_id);

                    $new_array = array();

                    foreach ($post_attachments as $attachment) {
                        $new_array[] = $attachment;
                    }

                    $post->story_attachments = $new_array;

                    $post->save();
                }
            }
        }

        echo '<script>window.opener.alert("File deleted successfully!");window.opener.location.reload();window.opener = window.self;window.close();</script>';
    }

    private function removeBlogFileFromStrorage($file_name) {
        if (Storage::exists('public/story/' . $file_name)) {
            Storage::delete('public/story/' . $file_name);

            if (Storage::exists('public/story/thumbnails/' . $file_name)) {
                Storage::delete('public/story/thumbnails/' . $file_name);
            }

            return true;
        }

        return false;
    }

    public function listBlogCategories() {

        return view('story::list-categories');
    }

    public function listBlogCategoriesData() {

        $all_categories = StoryCategory::translatedIn(\App::getLocale())->get();

        return Datatables::of($all_categories)
                        ->addColumn("parent", function($category) {
                            if ($category->parentCat) {
                                return $category->parentCat->translate()->name;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('Language', function($category) {
                            $language = '<button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="langDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Another Language <span class="caret"></span> </button>
                         <ul class="dropdown-menu multilanguage" aria-labelledby="langDropDown">';
                            if (count(config("translatable.locales_to_display"))) {
                                foreach (config("translatable.locales_to_display") as $locale => $locale_full_name) {
                                    if ($locale != 'en') {
                                        $language .= '<li class="dropdown-item"> <a href="story-category/' . $category->id . '/' . $locale . '">' . $locale_full_name . '</a></li>';
                                    }
                                }
                            }
                            return $language;
                        })
                        ->make(true);
    }

    public function createBlogCategories(Request $request) {
        if ($request->method() == "GET") {
            $existing_categories = StoryCategory::where('parent_id', null)->withTranslation()->get();
//            dd($existing_categories);
            $tree = $this->getCategoryTree($existing_categories->toTree(), '&nbsp;&nbsp;');
//              $tree = $this->getCategoryTree($existing_categories->toTree());
//              dd($tree);
            return view("story::create-category", array('categories' => $existing_categories, "tree" => $tree));
        } else {
            $data = $request->all();
            $data['name'] = (trim($data['name']));
//            $data['slug']=(trim($data['slug']));
            $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:story_category_translations',
//                        'slug' => 'required|unique:post_categories',
                            ), array('name.required' => 'Please enter name',
//                        'slug.required' => 'Please enter url',
//                        'slug.unique' => 'This url is already exists',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                $parent_cat = StoryCategory::find($request->parent_id);

                $created_category = StoryCategory::create(array('created_by' => Auth::user()->id, 'parent_id' => $request->parent_id, 'slug' => $request->slug));

                $translated_category = $created_category->translateOrNew(\App::getLocale());
                $translated_category->name = $request->name;
                $translated_category->locale = \App:: getLocale();
                $translated_category->story_category_id = $created_category->id;
                $translated_category->save();

                return redirect("admin/story-categories")->with('status', 'Story Category created successfully!');
            }
        }
    }

    public function updateBlogCategory(Request $request, $category_id, $locale = "") {

        $category = StoryCategory::find($category_id);
        $flag = 1;
        //dd($category);
        if ($category) {
            $translated_category = $category->translateOrNew($locale);

            if ($request->method() == "GET") {
                $existing_categories = StoryCategory::withTranslation()->where('id', '<>', $category_id)->get();

                $tree = $this->getCategoryTree($existing_categories->toTree(), '&nbsp;&nbsp;');

                if (isset($locale) && $locale != 'en' && $locale != '') {

                    return view("story::update-language-category", array('category' => $translated_category, 'main_catgeoy_details' => $category));
                } else {
                    return view("story::update-category", array('category' => $translated_category, 'parent_id' => $category->parent_id, 'locale' => $locale, 'tree' => $tree, 'main_catgeoy_details' => $category));
                }
            } else {

                $data = $request->all();
                $check_duplicate_category = StoryCategoryTranslation::where('story_category_id', '<>', $category_id)->where('name', '=', $data['name'])->get();
                $count = count($check_duplicate_category);
                if ($locale != 'en' && $locale != '') {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|unique:story_category_translations',
                    ));
                }
                if ($count == 0) {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|min:3|unique:story_category_translations,name,' . str_slug($category->id),
                                'slug' => 'required|unique:story_categories,slug,' . str_slug($category->id),
                                    ), array('name.required' => 'Please enter name',
                                'slug.required' => 'Please enter url',
                                'slug.unique' => 'This url is already exists',
                    ));
                    if ($validate_response->fails()) {
                        return redirect($request->url())->withErrors($validate_response)->withInput();
                    }
                }
                if ($count != 0) {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|min:3|unique:story_category_translations',
                                'slug' => 'required|unique:story_categories,slug,' . str_slug($category->id),
                                    ), array('name.required' => 'Please enter name',
                                'slug.required' => 'Please enter url',
                                'slug.unique' => 'This url is already exists',
                    ));
                    if ($validate_response->fails()) {
                        return redirect($request->url())->withErrors($validate_response)->withInput();
                    }
                }
                if ($flag == 1) {
                    $translated_category->name = $request->name;

                    if ($locale != 'en' && $locale != '') {
                        $translated_category->story_category_id = $category->id;
                        $translated_category->locale = $locale;
                        $translated_category->name = $request->name;
                    } else {
                        $parent_cat = StoryCategory::find($request->parent_id);
                        $category->parent_id = $request->parent_id;
                        $category->slug = $request->slug;
                        $category->save();
                    }
                    $translated_category->save();
                    return redirect("admin/story-categories")->with('status', 'Story Category updated successfully!');
                }
            }
        } else {
            return redirect('admin/story-categories');
        }
    }

    public function deleteBlogCategory($category_id) {

        $category = StoryCategory::find($category_id);
        if ($category) {
            $category->delete();
            return redirect("admin/story-categories")->with('status', 'Story Category deleted successfully!');
        } else {
            return redirect('admin/story-categories');
        }
    }

    public function deleteSelectedBlogCategory($category_id) {

        $category = StoryCategory::find($category_id);
        if ($category) {
            $category->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function viewPost(Request $request, $post_url) {

        $page = Story::where('story_url', $post_url)->first();
        if ($page && $page->story_status) {

            if ($request->method() == "GET") {
                $page_information = $page->translateOrDefault(\App::getLocale());
                $comments = StoryComment::where('story_id', $page->id)->first();
                return view('story::view-story', array('comments' => $comments, 'page' => $page, 'page_information' => $page_information));
            } else {
                // Post Comments

                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'comment' => 'required|min:50',
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    $comment_data = array(
                        'comment' => $request->comment,
                        'commented_by' => Auth::user()->id,
                        'story_id' => $page->id
                    );

                    $attachments = array();
//                    dd($request->hasFile('attachments'));
                    if ($page->allow_attachments_in_comments && $request->hasFile('attachments')) {

                        $uploaded_files = $request->file('attachments');
//                        dd($uploaded_files);
                        foreach ($uploaded_files as $uploaded_file) {
                            $extension = $uploaded_file->getClientOriginalExtension();

                            $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                            Storage::put('/public/story/comment_attachment/' . $new_file_name, file_get_contents($uploaded_file->getRealPath()));

                            $attachments[] = array("original_name" => $new_file_name, "display_name" => $uploaded_file->getClientOriginalName());
                        }
                    }
//                    dd($attachments);

                    $comment_data['comment_attachments'] = $attachments;

                    $post_comment = StoryComment::create($comment_data);
//                    dd($attachments);
                    $post_comment->comment_attachments = $attachments;
                    $post_comment->save();

                    return redirect($request->url());
                }
            }
        } else {
            abort(404);
        }
    }

    public function viewPostsForTag($tag_slug) {
        $obj_tag = Tag::where('slug', $tag_slug)->first();

        if ($obj_tag) {
            $posts = $obj_tag->posts;

            $existing_categories = PostCategory::withTranslation()->get();

            $tree = $this->getCategoryTreeList($existing_categories->toTree(), '<li>', true);


            return view("blog::search-by-tag", array('posts' => $posts, 'tag' => $obj_tag, 'category_tree' => $tree));
        } else {
            abort(404);
        }
    }

    public function viewPostsForCategory($category_slug) {
        $obj_category = StoryCategory::where('slug', $category_slug)->first();
        if ($obj_category) {

            $posts = $obj_category->posts;

            $existing_categories = StoryCategory::withTranslation()->get();

            $tree = $this->getCategoryTreeList($existing_categories->toTree(), '<li>', true);


            return view("story::search-by-category", array('posts' => $posts, 'category' => $obj_category, 'category_tree' => $tree));
        } else {
            abort(404);
        }
    }

    private function getCategoryTree($nodes, $prefix = "-") {
        $arr_cats = array();
        $traverse = function ($categories, $prefix) use (&$traverse, &$arr_cats ) {

            foreach ($categories as $category) {


                $arr_cats[] = new categoryTreeHolder($prefix . ' ' . $category->name, $category->id);

                $traverse($category->children, $prefix . $prefix);
            }
        };

        $traverse($nodes, $prefix);

        return $arr_cats;
    }

    public function viewBlogPosts() {
        $posts = Story::translatedIn(\App::getLocale())->where('story_status', '1')->orderBy('updated_at', 'desc')->paginate(5);

        $posts_latest = Story::translatedIn(\App::getLocale())->where('story_status', '1')->orderBy('updated_at', 'desc')->first();

        $existing_categories = StoryCategory::withTranslation()->get();

        $tree = $this->getCategoryTreeList($existing_categories->toTree(), '<li>', true);

        return view('story::story', array('posts' => $posts, 'posts_latest' => $posts_latest, 'category_tree' => $tree));
    }

    public function searchPost($keyword) {
        $matching_posts = Story::search(array('short_description', 'title', 'description'), "%$keyword%")->where('story_status', '1')->get();
        $existing_categories = StoryCategory::withTranslation()->get();
        $tree = $this->getCategoryTreeList($existing_categories->toTree(), '<li>', true);
        return view('story::search-results', array('posts' => $matching_posts, 'category_tree' => $tree, 'keyword' => $keyword));
    }

    private function getCategoryTreeList($nodes, $prefix = "</li><li>", $include_anchor = false) {
        $arr_cats = array();
        $traverse = function ($categories, $prefix) use (&$traverse, &$arr_cats, $include_anchor) {

            foreach ($categories as $category) {

                $disp_name = $prefix . ' ' . $category->name . " (" . count($category->posts) . ")</li>";

                if ($include_anchor) {
                    $disp_name = $prefix . '<a href="' . url('/story/categories/' . $category->slug) . '" title="Click to view posts">' . $category->name . " (" . count($category->posts) . ")</a></li>";
                }

                $arr_cats[] = new categoryTreeHolder($disp_name, $category->id, $category->slug);

                $traverse($category->children, "<ul class='subtree'><li>");
            }
        };

        $traverse($nodes, $prefix);

        return $arr_cats;
    }

}

class categoryTreeHolder {

    public $display = '';
    public $id = '';
    public $slug = '';

    public function __construct($display, $id, $slug = '') {
        $this->id = $id;
        $this->display = $display;
        $this->slug = $slug;
    }

}
