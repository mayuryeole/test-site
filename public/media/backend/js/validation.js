jQuery(document).ready(function () {
    jQuery.validator.addMethod("allZero", function (value, element) {
        if (value > 0) {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid name");

    jQuery.validator.addMethod("phoneNumber", function (value, element) {
        if (value != "" && value > 0 && value.length == 10) {
            return true;
        } else {
            return false;
        }

    }, "Please enter 10 digit mobile number");

    jQuery.validator.addMethod("gstNumber", function (value, element) {
        if (value != "" && value > 0 && value.length == 15) {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid GST number");

    jQuery.validator.addMethod("panNumber", function (value, element) {
        if (value != "" && value > 0 && value.length == 10) {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid PAN Card number");

    jQuery.validator.addMethod("tax_id", function (value, element) {
        if (value != "" && value > 0 && value.length == 9) {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid Tax Id");


    jQuery.validator.addMethod("validzipcode", function (value, element) {
        return this.optional(element) || /^[ A-Za-z0-9-]*$/.test(value);
    }, "Please enter valid zip code.");

    //

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");

    jQuery.validator.addMethod("checkurl", function (value, element) {
//      return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);

        return this.optional(element) || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)?[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
    }, "Please enter valid url");
    jQuery.validator.addMethod("testurl", function (value, element) {
        return /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/g.test(value);
    }, "Please enter valid url");

    jQuery.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]*$/.test(value);
    }, "Please enter valid name");
    jQuery.validator.addMethod("alphanumericwithoutzero", function (value, element) {
        return this.optional(element) || /^[a-zA-Z1-9]+[a-zA-Z0-9]*$/.test(value);
    }, "Please enter alphanumeric  and space");

    jQuery.validator.addMethod("alphanumericspacewithoutzero", function (value, element) {
        return this.optional(element) || /^[a-zA-Z]+[a-zA-z0-9\s]*$/.test(value);
    }, "Please enter alphanumeric  and space");
    //  /^[a-z\-_\s]+$/i
    jQuery.validator.addMethod("documentOnly", function (value, element) {
        return this.optional(element) || /^([a-zA-Z0-9\s_\\.\-:])+(.doc|.docx|.pdf)$/.test(value);
    }, "Select valid input file type");

    jQuery.validator.addMethod("imageOnly", function (value, element) {
        return this.optional(element) || /^([a-zA-Z0-9\s_\\.\-:])+(.png|.jpg|.gif)$/.test(value);
    }, "Select valid input file type");


    jQuery.validator.addMethod("csvOnly", function (value, element) {
        return this.optional(element) || /^.+\.(XLS|XLSX|xlsx|xls|csv)$/.test(value);
    }, "Select valid input file type");

    jQuery.validator.addMethod("valueNotEquals", function (value, element, arg) {
        return arg != jQuery(element).find('option:selected').text();
    }, "Please select user tpye.");

    jQuery.validator.addMethod("needsSelection", function (value, element) {
        return $(element).multiselect("getSelected").length > 0;
    });

    jQuery.validator.addMethod("alphaSpaceHypUnderscore", function (value, element) {
        return this.optional(element) || /^[a-z\-_\s]+$/i.test(value);
    }, 'Name only contains alphabets, - , _ and space');

    jQuery.validator.addMethod("alphaSpace", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, 'Name only contains alphabets and space');


    jQuery.validator.addMethod("greaterThan",
        function (value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val())
                || (Number(value) > Number($(params).val()));
        });
    jQuery.validator.addMethod("lessThan",
        function (value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) < new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val())
                || (Number(value) < Number($(params).val()));
        });


    jQuery.validator.addMethod("alphaNumericFirstChar", function (value, element) {
        return this.optional(element) || /^[A-Za-z]*[0-9]*$/i.test(value);
    }, 'Name contains alphanumeric');

    jQuery.validator.addMethod("floatOnly", function (value, element) {
        return this.optional(element) || /^[+]?\d+(\.\d+)?$/.test(value);
    });
// /^[+-]?\d+(\.\d+)?$/
//  ^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$
// /^[0-9]+\.[0-9]*$/
    //(?<=^| )\d+(\.\d+)?(?=$| )|(?<=^| )\.\d+(?=$| )

    /* landing Form Validation Start */
    jQuery("#admin_login").validate({
        errorClass: 'text-danger',
        rules: {
            email:
                {
                    required: true,
                    email: true

                },
            password:
                {
                    required: true,
                    minlength: 6
                }

        },
        messages: {
            email: {
                required: "Please enter email.",
                email: "Please enter valid email."
            },
            password: {
                required: "Please enter password.",
                minlength: "Please enter minimum 6 characters."
            }

        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_profile").validate({
        errorClass: 'text-danger',
        rules: {
            user_mobile:
                {
                    minlength: 10,
                    maxlength: 10
                },
            pan_card_number: {
                minlength: 10,
                maxlength: 10
            },
            gst_no: {
                minlength: 15,
                maxlength: 15
            },
            tax_id: {
                minlength: 9,
                maxlength: 9
            }


        },
        messages: {
            user_mobile: {
                required: "Please enter mobile number.",
                minlength: "Mobile number should contain 10 digits ",
                maxlength: "Mobile number should contain 10 digits "
            },
            pan_card_number: {
                minlength: "Please enter valid PAN Card Number",
                maxlength: "Please enter valid PAN Card Number"
            },
            gst_no: {
                minlength: "Please enter valid GST Number",
                maxlength: "Please enter valid GST Number"
            },
            tax_id: {
                minlength: "Please enter valid TAX Id",
                maxlength: "Please enter valid TAX Id"
            }

        },
        submitHandler: function (form) {

            form.submit();
        }
    });


    jQuery("#create_user_register").validate({
        errorClass: 'text-danger',
        rules: {
            user:
                {
                    required: true,
                },
            first_name:
                {
                    required: true,
                    lettersonly: true


                },
            last_name: {
                required: true,
                lettersonly: true

            },
            email:
                {
                    required: true,
                    email: true,
                    remote: {
                        url: javascript_site_path + 'chk-email-duplicate',
                        method: 'get'
                    }

                },
            password:
                {
                    required: true,
                    minlength: 6
                },
            password_confirmation:
                {
                    required: true,
//                function(){
//                    return $("#password").val()!='';
//                },
                equalTo: "#password"
            },
            user_mobile:
                {
//                        required: true,
                minlength: 10,
                maxlength: 10
            },
            pan_card_number: {
                minlength: 10,
                maxlength: 10
            },
            gst_no: {
                minlength: 15,
                maxlength: 15
            },
            tax_id: {
                minlength: 9,
                maxlength: 9
            }

        },
        messages: {
            user:
                {
                    required: "Please select user type"
                },
            first_name: {
                required: "Please enter first name."
            },
            last_name: {
                required: "Please enter last name."
            },
            email: {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "This email is already taken"
            },
            password: {
                required: "Please enter password.",
                minlength: "Please enter minimum 6 characters."
            },
            password_confirmation: {
                required: "Please enter confirm password.",
                equalTo: "Confirm password is not matching with above password entered."
            },
            user_mobile: {
//                required: "Please enter mobile number.",
                minlength: "Mobile number should contain 10 digits ",
                maxlength: "Mobile number should contain 10 digits "
            },
            pan_card_number: {
                minlength: "Please enter valid PAN Card Number",
                maxlength: "Please enter valid PAN Card Number"
            },
            gst_no: {
                minlength: "Please enter valid GST Number",
                maxlength: "Please enter valid GST Number"
            },
            tax_id: {
                minlength: "Please enter valid TAX Id",
                maxlength: "Please enter valid TAX Id"
            }

        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#create_user").validate({
        errorClass: 'text-danger',
        rules: {
            first_name:
                {
                    required: true,
                    lettersonly: true


                },
            last_name: {
                required: true,
                lettersonly: true

            },
            email:
                {
                    required: true,
                    email: true,
                    remote: {
                        url: javascript_site_path + 'chk-email-duplicate',
                        method: 'get'
                    }

                },
            password:
                {
                    required: true,
                    minlength: 6
                },
            password_confirmation:
                {
                    required: true,
                    equalTo: "#password"
                },
            gender:
                {
                    required: true
                },
            user_mobile:
                {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
            role: {
                required: true
            }

        },
        messages: {
            first_name: {
                required: "Please enter first name."
            },
            last_name: {
                required: "Please enter last name."
            },
            email: {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "This email is already taken"
            },
            password: {
                required: "Please enter password.",
                minlength: "Please enter minimum 6 characters."
            },
            password_confirmation: {
                required: "Please enter confirm password.",
                equalTo: "Confirm password is not matching with above password entered."
            },
            gender: {
                required: "Please select gender."
            },
            user_mobile: {
                required: "Please enter mobile number."
            },
            role: {
                required: "Please select role."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    $("#myform").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: "check-email.php",
                    type: "post",
                    data: {
                        username: function () {
                            return $("#username").val();
                        }
                    }
                }
            }
        }
    });


    jQuery("#create-sub-sub-cat").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    required: true,
                    alphaSpace: true,
                    remote: {
                        url: javascript_site_path + "check-duplicate-category",
                        type: "get",
                        data: {
                            parent_id: function () {
                                return $("#parent_id").val();
                            }
                        }
                    }
                },
        },
        messages: {
            name: {
                required: "Please enter name.",
                remote: "Name already available."
            },
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#create-cat").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    required: true,
                    alphaSpace: true,
                    remote: {
                        url: javascript_site_path + "check-duplicate-main-category",
                        type: "get",
                        data: {
                            parent_id: function () {
                                return $("#parent_id").val();
                            }
                        }
                    }
                }
        },
        messages: {
            name: {
                required: "Please enter name.",
                remote: "Name already available."
            },
        },
        submitHandler: function (form) {
            $('input[type=checkbox]').removeAttr('disabled');
            form.submit();
        }
    });
    jQuery("#update-cat").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    required: true,
                    alphaSpace: true
                },
        },
        messages: {
            name: {
                required: "Please enter category name",
                alphaSpace: "Name only contains alphabets and space"
            },
        },
        submitHandler: function (form) {
            $('input[type=checkbox]').removeAttr('disabled');
            form.submit();
        }
    });

    jQuery("#create_blog").validate({
        errorClass: 'text-danger',

        rules: {
            title:
                {
                    required: true,
                    alphaSpace: true

                },
            short_description: {
                required: true

            },
            url:
                {
                    required: true,
                    checkurl: true
                },

            photo:
                {
                    required: true
                },
            allow_comments:
                {
                    required: true
                },
            post_status:
                {
                    required: true
                },
            seo_title:
                {
                    required: true
                },
            seo_keywords:
                {
                    required: true
                },
            seo_description: {
                required: true
            },
            description: {
                required: true
            }

        },
        messages: {
            title: {
                required: "Please enter name."
            },
            short_description: {
                required: "Please enter short description."
            },
            url:
                {
                    required: "Please enter url"
                },
            photo: {
                required: "Please select photo."
            },
            allow_comments: {
                required: "Please select allow comments or not."
            },
            post_status: {
                required: "Please select publish status."
            },
            seo_title: {
                required: "Please enter seo title."
            },
            seo_keywords: {
                required: "Please enter seo keywords."

            },
            seo_description: {
                required: "Please enter seo description."

            },
            description: {
                required: "Please enter description."

            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });
    jQuery("#update_blog").validate({
        errorClass: 'text-danger',
        rules: {
            title:
                {
                    alphaSpace: true
                }
        },
        messages: {
            title: {
                alphaSpace: "Name only contains alphabets and space"
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update-blog-cat").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    alphaSpace: true
                },
            slug:
                {
                    checkurl: true
                }
        },
        messages: {
            name: {
                alphaSpace: "Name only contains alphabets and space."
            },
            slug:
                {}
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#create-blog-cat").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    required: true,
                    alphaSpace: true

                },
            slug:
                {
                    required: true,
                    checkurl: true
                }
        },
        messages: {
            name: {
                required: "Please enter name"

            },
            slug:
                {
                    required: "Please enter url"

                }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });


    jQuery("#create-contact-cat").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    required: true,
                    alphaSpace: true
                }
        },
        messages: {
            name: {
                required: "Please enter name."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });


    jQuery("#update-contact-cat").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    alphaSpace: true
                }
        },
        messages: {
            name: {
                alphaSpace: "Name only contains alphabets and space."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_product_inventory").validate({
        errorClass: 'text-danger',
        rules: {
            quantity:
                {
                    required: true,
                    digits: true,
                    maxlength: 5,
                    min: 1
                }
        },
        messages: {
            quantity: {
                required: "Please enter Quantity.",
                digits: "Please enter numbers only",
                maxlength: "Please enter quantity upto 5 digit",
                min: "Please enter quantity greater than 1"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    jQuery("#update_product_attributes").validate({
        errorClass: 'text-danger',
        rules: {
            value:
                {
                    required: true,
                    alphaSpace: true
                }
        },
        messages: {
            value: {
                required: "Please enter Quantity."
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


    jQuery("#create_rivaah_gallery").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphaSpace: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-rivaah-gallery",
                    type: "get"
                }
            },
            description: {
                required: true
            }

        },
        messages: {
            category: {
                required: "Please select category."
            },
            name: {
                required: "Please enter Rivaah name.",
                remote: "Rivaah Name already available"
            },
            description: {
                required: "Please enter description product"
            }


        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    jQuery("#update_rivaah_gallery").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphaSpace: true,
                remote: {
                    url: javascript_site_path + "check-update-duplicate-rivaah-gallery",
                    type: "get",
                    data: {
                        old_name: function () {
                            return $("#old_name").val();
                        }
                    }
                }
            },
            description: {
                required: true
            }

        },
        messages: {
            category: {
                required: "Please select category."
            },
            name: {
                required: "Please enter Rivaah name.",
                remote: "Rivaah Name already available"
            },
            description: {
                required: "Please enter description product"
            }


        },
        submitHandler: function (form) {
            form.submit();
        }
    });


    /*products*/
    jQuery("#create_product").validate({
        errorClass: 'text-danger',
        //ignore: ':hidden:not("#color")',
        rules: {
            category:
                {
                    required: true

                },
            product_name: {
                required: true,
                // alphaSpace: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-product",
                    type: "get"
                }
            },
            photo:
                {
                    required: true
                },
            product_clip:
                {
                    required: true
                },
            'productColor[]': {
                required: true
            },
            price:
                {
                    required: true,
                    floatOnly: true,
                    maxlength: 7,
                    min: 0.01
                },
            quantity:
                {
                    required: true,
                    digits: true,
                    maxlength: 5,
                    min: 1
                },
            is_featured:
                {
                    required: true
                },
            status:
                {
                    required: true
                },
            is_available: {
                required: true
            },
            pre_order: {
                required: true
            },
            description: {
                required: true
            }

        },
        messages: {
            category: {
                required: "Please select category."

            },
            product_name: {
                required: "Please enter product name.",
                remote: "Product Name already available"
            },
            photo: {
                required: "Please choose product image."
            },
            product_clip: {
                required: "Please choose product video."
            },
            'productColor[]': {
                required: "Please select product color"
            },
            price: {
                required: "Please enter price of product.",
                floatOnly: "Please enter numbers only",
                maxlength: "Please enter price upto 7 digit number",
                min: "Please enter price greater than 0"
            },
            quantity: {
                required: "Please enter quantity of product.",
                digits: "Please enter numbers only",
                maxlength: "Please enter quantity upto 5 digit",
                min: "Please enter quantity greater than 1"
            },
            is_featured: {
                required: "Please select product featured or not."
            },
            status: {
                required: "Please select status of product."
            },
            is_available: {
                required: "Please select product availability."
            },
            pre_order: {
                required: "Please select product pre-order or not."
            },
            description: {
                required: "Please enter description of product"
            }
        },
        submitHandler: function (form) {
            form.submit();

        }
    });

    jQuery("#update_attribute").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                alphaSpace: true,
                required: true,
                remote: {
                    url: javascript_site_path + "check-update-duplicate-attribute-name",
                    type: "get",
                    data: {
                        old_name: function () {
                            return $("#old_name").val();
                        }
                    }
                }
            }
        },
        messages: {
            name: {
                required: "Please enter attribute name.",
                remote: "Attribute Name already available."
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


    jQuery("#create_attribute").validate({
        errorClass: 'text-danger',
        rules: {
            attribute_name: {
                alphaSpace: true,
                required: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-attribute-name",
                    type: "get"
                }


            }
        },
        messages: {
            attribute_name: {
                required: "Please enter attribute name.",
                remote: "Attribute Name already available."
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    jQuery("#update_product").validate({
        errorClass: 'text-danger',
        ignore: ':hidden:not("#color")',
        rules: {
            category:
                {
                    required: true

                },
            product_name: {
                required: true,
                // alphaSpace: true,
                remote: {
                    url: javascript_site_path + "check-update-duplicate-product",
                    type: "get",
                    data: {
                        product_old_name: function () {
                            return $("#product_old_name").val();
                        }
                    }
                }
            },
            'productColor[]': {
                required: true
            },
            price:
                {
                    required: true,
                    floatOnly: true,
                    maxlength: 7,
                    min: 1
                },
            quantity:
                {
                    required: true,
                    digits: true,
                    maxlength: 5,
                    min: 1
                },
            is_featured:
                {
                    required: true
                },
            status:
                {
                    required: true
                },
            is_available: {
                required: true
            },
            pre_order: {
                required: true
            },
            description: {
                required: true
            }

        },
        messages: {
            category: {
                required: "Please select category."

            },
            product_name: {
                required: "Please enter product name.",
                remote: "Product Name already available"
            },
            'productColor[]': {
                required: "Please select product color"
            },
            price: {
                required: "Please enter price of product.",
                floatOnly: "Please enter numbers only",
                maxlength: "Please enter price upto 7 digit number",
                min: "Please enter price greater than 1"
            },
            quantity: {
                required: "Please enter quantity of product.",
                digits: "Please enter numbers only",
                maxlength: "Please enter quantity upto 5 digit number",
                min: "Please enter quantity greater than 1"
            },
            is_featured: {
                required: "Please select product featured or not."
            },
            status: {
                required: "Please select status of product."
            },
            is_available: {
                required: "Please select product availability."
            },
            pre_order: {
                required: "Please select product pre-order or not."
            },
            description: {
                required: "Please enter description of product"
            }
        },
        submitHandler: function (form) {

            form.submit();

        }
    });


    jQuery("#create_collection_style").validate({
        errorClass: 'text-danger',
        rules: {
            collection_style_name: {
                alphanumericspacewithoutzero: true,
                required: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-collection-style",
                    type: "get"
//                        data: {
//                          parent_id: function() {
//                            return $( "#parent_id" ).val();
//                          }
//                        }
                }
            },
            photo:
                {
                    required: true
                }
        },
        messages: {
            collection_style_name: {
                required: "Please enter name of collection style.",
                remote: "Collection Style Name already available"
            },
            photo: {
                required: "Please choose collection style image."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });
    jQuery("#update_collection_style").validate({
        errorClass: 'text-danger',
        rules: {
            collection_style_name: {
                alphanumericspacewithoutzero: true,
                required: true,
                remote: {
                    url: javascript_site_path + "check-update-duplicate-collection-style",
                    type: "get",
                    data: {
                        old_name: function () {
                            return $("#old_name").val();
                        }
                    }
                }
            },
            photo:
                {
                    required: true
                }
        },
        messages: {
            collection_style_name: {
                required: "Please enter name of collection style.",
                remote: "Collection Style Name already available"
            },
            photo: {
                required: "Please choose collection style image."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });


    jQuery("#create_style").validate({
        errorClass: 'text-danger',
        rules: {
            style_name: {
//                required: true,
                alphanumericspacewithoutzero: true,
                required: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-style",
                    type: "get"
//                        data: {
//                          parent_id: function() {
//                            return $( "#parent_id" ).val();
//                          }
//                        }
                }
            },
            photo:
                {
                    required: true
                }
        },
        messages: {
            style_name: {
                required: "Please enter name of style.",
                remote: "Style Name already available"
            },
            photo: {
                required: "Please choose style image."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#create_occasion").validate({
        errorClass: 'text-danger',
        rules: {
            occasion_name: {
                required: true,
                alphaSpace: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-occasion",
                    type: "get"
                }

            }
        },
        messages: {
            occasion_name: {
                required: "Please enter name of occasion.",
                remote: "Occasion Name already available."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#give_discount").validate({
        errorClass: 'text-danger',
        rules: {
            percentage: {
                required: true,
                floatOnly: true,
                max: 100,
                min: 0.01

            },
            max_quantity: {
                required: true,
                digits: true,
                min: 1,
                maxlength: 5
            },
            discount_valid_from: {
                required: true,
                lessThan: "#discount_valid_to"
            },
            discount_valid_to: {
                required: true,
                greaterThan: "#discount_valid_from"
            }
        },
        messages: {
            percentage: {
                required: "Please enter coupon percentage.",
                floatOnly: "Please enter numbers only",
                max: "Please enter number upto 100",
                min: "Please enter number greater than 0"

            },
            max_quantity: {
                required: "Please enter quantity of product.",
                digits: "Please enter number only",
                min: "Please enter quantity greater than 1",
                maxlength: "Please enter quantity upto 5 digit"

            },
            discount_valid_from: {
                required: "Please select discount valid from date",
                lessThan: "discount_valid_from should be less than discount_valid_to"
            },
            discount_valid_to: {
                required: "Please select discount valid to date",
                greaterThan: "discount_valid_to should be greater than discount_valid_from"
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#give_category_discount").validate({
        errorClass: 'text-danger',
        rules: {
            percentage: {
                required: true,
                floatOnly: true,
                max: 100,
                min: 0.01
            },
            max_quantity: {
                required: true,
                digits: true,
                min: 1,
                maxlength: 5

            },
            discount_valid_from: {
                required: true,
                lessThan: "#discount_valid_to"
            },
            discount_valid_to: {
                required: true,
                greaterThan: "#discount_valid_from"
            },
        },
        messages: {
            percentage: {
                required: "Please enter discount percentage.",
                floatOnly: "Please enter numbers only",
                max: "Please enter number upto 100",
                min: "Please enter percentage greater than 0"
            },
            max_quantity: {
                required: "Please enter quantity of product.",
                digits: "Please enter float values only",
                min: "Please enter quantity greater than 1",
                maxlength: "Please enter quantity upto 5 digit"
            },
            discount_valid_from: {
                required: "Please select discount valid from date",
                lessThan: "discount_valid_from should be less than discount_valid_to"
            },
            discount_valid_to: {
                required: "Please select discount valid to date",
                greaterThan: "discount_valid_to should be greater than discount_valid_from"
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });
    jQuery("#create_product_image").validate({
        errorClass: 'text-danger',
        rules: {
            color :{
                required: true
            },
            'photo[]': {
                required: true

            }
        },
        messages: {
            color :{
                required: "Please select product color."
            },
            'photo[]': {
                required: "Please select product image."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_product_image").validate({
        errorClass: 'text-danger',
        rules: {
            'photo[]': {
                required: true
            }
        },
        messages: {
            'photo[]': {
                required: "Please select product image."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_product_style").validate({
        errorClass: 'text-danger',
        rules: {
            style_name: {
                required: true,
                alphanumericspacewithoutzero: true

            }
        },
        messages: {
            style_name: {
                required: "Please enter style name"

            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });
    jQuery("#file-import").validate({
        errorClass: 'text-danger',
        rules: {
            import_file: {
                required: true,
                csvOnly: true
            }
        },
        messages: {
            import_file: {
                required: "Please select file to import.",
                csvOnly: "select valid input file format"
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });
    jQuery("#create_gallery").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphanumericspacewithoutzero: true
            },
            description: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please select gallery name."

            },
            description: {
                required: "Please select gallery description."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_gallery").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphanumericwithoutzero: true
            },
            description: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please select gallery name."

            },
            description: {
                required: "Please select gallery description."
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });
    jQuery("#update_product_occasion").validate({
        errorClass: 'text-danger',
        rules: {
            occasion_name: {
                required: true,
                alphaSpace: true
            }
        },
        messages: {
            occasion_name: {
                required: "Please select occasion name."

            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_coupon").validate({
        highlight: false,
        errorElement: 'div',
        rules: {
            name: {
                required: true,
                alphanumericwithoutzero: true
            },
            code_type: {
                required: true
            },
            user_type: {
                required: true
            },
            coupon_code: {
                required: true,
                alphanumeric: true,
                remote: {
                    url: javascript_site_path + 'chk-coupon-duplicate',
                    method: 'get'
                }
            },
            amount: {
                required: true,
                floatOnly: true,
                maxlength: 7,
                min: 1
            },
            percentage: {
                required: true,
                floatOnly: true,
                max: 100,
                min: 0.01
            },
            min_purchase_amt: {
                required: true,
                floatOnly: true,
                maxlength: 7,
                min: 1
            },
            quantity: {
                required: true,
                digits: true,
                min: 1,
                maxlength: 5
            },
            radioChange: {
                required: true
            },
            valid_from: {
                required: true,
                lessThan: "#valid_to"
            },
            valid_to: {
                required: true,
                greaterThan: "#valid_from"
            },
            status: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter name."
            },
            code_type: {
                required: "Please select code type."
            },
            user_type: {
                required: "Please select user type."
            },
            coupon_code: {
                required: "Please enter code.",
                remote: "This code is already taken"
            },
            amount: {
                required: "Please enter amount.",
                floatOnly: "Please enter numbers only",
                maxlength: "Please enter amount value upto 7 digits",
                min: "Please enter value greater than 1"
            },
            percentage: {
                required: "Please enter percentage.",
                floatOnly: "Please enter numbers only",
                max: "Please enter value upto 100",
                min: "Please enter value greater than 0"
            },
            min_purchase_amt: {
                required: "Please enter minimum purchase amount.",
                floatOnly: "Please enter numbers only",
                maxlength: "Please enter amount value upto 7 digits",
                min: "Please enter value greater than 1"
            },
            images: {
                required: "Please select image."
            },
            quantity: {
                required: "Please enter quantity.",
                digits: "Please enter number only",
                min: "Please enter quantity greater than 1",
                maxlength: "Please enter quantity upto 5 digit"
            },
            radioChange: {
                required: "Please enter select amount or percentage."
            },
            valid_from: {
                required: "Please select from date.",
                lessThan: "valid_from should be less than valid_to"
            },
            valid_to: {
                required: "Please select to date.",
                greaterThan: "valid_to should be greater than valid_from"
            },
            status: {
                required: "Please select status."

            },
            description: {
                required: "Please enter description."

            }
        },
        submitHandler: function (form) {
            $("#btn_submit").hide();
            form.submit();
        }
    });

    jQuery("#create_coupon").validate({
        highlight: false,
        errorElement: 'div',
        rules: {
            name: {
                required: true,
                alphanumericwithoutzero: true
            },
            code_type: {
                required: true
            },
            user_type: {
                required: true
            },
            coupon_code: {
                required: true,
                alphanumeric: true,
                remote: {
                    url: javascript_site_path + 'chk-coupon-duplicate',
                    method: 'get'
                }
            },
            amount: {
                required: true,
                floatOnly: true,
                maxlength: 7,
                min: 0.01
            },
            percentage: {
                required: true,
                floatOnly: true,
                max: 100,
                min: 0.01
            },
            min_purchase_amt:{
                required: true,
                floatOnly: true,
                maxlength: 7,
                min: 0.01
            },
            radioChange: {
                required: true
            },
            images: {
                required: true
            },
            quantity: {
                required: true,
                digits: true,
                maxlength: 5,
                min: 1
            },
            valid_from: {
                required: true,
                lessThan: "#valid_to"

            },
            valid_to: {
                required: true,
                greaterThan: "#valid_from"
            },
            status: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter name."
            },
            code_type: {
                required: "Please select code type"
            },
            user_type: {
                required: "Please select user type"
            },
            coupon_code: {
                required: "Please enter code.",
                remote: "This code is already taken"
            },
            amount: {
                required: "Please enter amount.",
                floatOnly: "Please enter numbers only",
                maxlength: "Please enter number less than 7 digit",
                min: "Please enter amount greater than 0"
            },
            percentage: {
                required: "Please enter percentage",
                floatOnly: "Please enter floats value only",
                max: "Please enter value upto 100",
                min: "Please enter value greater than 0"
            },
            min_purchase_amt: {
                required: "Please enter minimum purchase amount.",
                floatOnly: "Please enter numbers only",
                maxlength: "Please enter number less than 7 digit",
                min: "Please enter minimum purchase amount greater than 0"
            },
            radioChange: {
                required: "Please select amount or percentage."
            },
            images: {
                required: "Please select image."
            },
            quantity: {
                required: "please enter quantity",
                digits: "Please enter numbers only",
                maxlength: "Please enter quantity upto than 5 digit",
                min: "Please enter quantity greater than 1"
            },
            valid_from: {
                required: "Please select from date.",
                lessThan: "Valid_from date should be less than valid_to date"
            },
            valid_to: {
                required: "Please select to date.",
                greaterThan: "Valid_to date should be greater than valid_from date"
            },
            status: {
                required: "Please select status."

            },
            description: {
                required: "Please enter description."

            },
        },
        submitHandler: function (form) {
            $("#btn_submit").hide();
            form.submit();
        }
    });

    jQuery("#create_country").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphaSpace: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-country",
                    type: "get"
                }
            },
            iso: {
                required: true,
                lettersonly: true,
                minlength: 2,
                maxlength: 2
            },
            digit: {
                required: true,
                digits: true,
                minlength: 1,
                maxlength: 1
            },
            pattern: {
                required: true
            }
            },
            messages: {
                name: {
                    required: "Please enter country name.",
                    remote: "Country Name already available."
                },
                iso: {
                    required: "Please enter iso code",
                    minlength: "Please enter min 2 alphabets",
                    maxlength: "Please enter max 2 alphabets"
                },
                digit:{
                    required: "Please enter digits",
                    minlength: "Please enter  atleast 1 digit",
                    maxlength: "Please enter atmost 1 digit"
                },
                pattern:{
                    required: "Please select pattern"
                }
            },
            submitHandler: function (form) {

                form.submit();
            }
        });

    jQuery("#create_city").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphaSpace: true
            },
            iso: {
                required: true,
                lettersonly: true,
                minlength: 2,
                maxlength: 2
            },
            country: {
                required: true

            },
            state: {
                required: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-city",
                    type: "get",
                    data: {
                        city_name: function () {
                            return $("#name").val();
                        },
                        country: function () {
                            return $("#country").val();
                        }
                    }
                }
            }
        },
        messages: {
            name: {
                required: "Please enter city name."
//                remote: "Occasion Name already available.",
            },
            iso: {
                required: "Please enter iso code",
                minlength: "Please enter min 2 alphabets",
                maxlength: "Please enter max 2 alphabets"
            },
            country: {
                required: "Please select country"
            },
            state: {
                required: "Please select state",
                remote: "City name already exists with selected state"
            }

        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_city").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphaSpace: true
            },
            iso: {
                required: true,
                lettersonly: true,
                minlength: 2,
                maxlength: 2
            },
            country: {
                required: true

            },
            state: {
                required: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-update-city",
                    type: "get",
                    data: {
                        city_name: function () {
                            return $("#name").val();
                        },
                        city_id: function () {
                            return $("#city_id").val();
                        },
                        country_id: function () {
                            return $("#country").val();
                        }
                    }
                }
            },
        },
        messages: {
            name: {
                required: "Please enter city name."
            },
            iso: {
                required: "Please enter iso code",
                minlength: "Please enter min 2 alphabets",
                maxlength: "Please enter max 2 alphabets"
            },
            country: {
                required: "Please select country"
            },
            state: {
                required: "Please select state",
                remote: "City name already exists with selected state"
            },

        },
        submitHandler: function (form) {

            form.submit();
        }
    });


    jQuery("#create_state").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphaSpace: true
            },
            iso: {
                required: true,
                lettersonly: true,
                minlength: 2,
                maxlength: 2
            },
            country: {
                required: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-state",
                    type: "get",
                    data: {
                        state_name: function () {
                            return $("#name").val();
                        }
                    }
                }
            }

        },
        messages: {
            name: {
                required: "Please enter state name."
            },
            iso: {
                required: "Please enter iso code",
                minlength: "Please enter min 2 alphabets",
                maxlength: "Please enter min 2 alphabets"
            },
            country: {
                required: "Please select country",
                remote: "State name already exists with selected country"
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });


    jQuery("#update_state").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                alphaSpace: true,
                required: true
            },
            iso: {
                required: true,
                lettersonly: true,
                minlength: 2,
                maxlength: 2
            },
            country: {
                required: true,
                remote: {
                    url: javascript_site_path + "check-duplicate-update-state",
                    type: "get",
                    data: {
                        state_name: function () {
//                              alert("sss");
                            return $("#name").val();
                        },
                        state_id: function () {
                            return $("#state_id").val();
                        }
                    }
                }
            }

        },
        messages: {
            name: {
                required: "Please enter state name."
            },
            iso: {
                required: "Please enter iso code",
                minlength: "Please enter min 2 alphabets",
                maxlength: "Please enter max 2 alphabets"
            },
            country: {
                required: "Please select country",
                remote: "State name already exists with selected country"
            }

        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_country").validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                alphaSpace: true
            },
            iso: {
                required: true,
                lettersonly: true,
                minlength: 2,
                maxlength: 2
            },
            digit:{
                 required:true,
                 digits:true,
                minlength:1,
                maxlength:1
            },
            pattern:{
                required:true
            }
        },
        messages: {
            name: {
                required: "Please enter name of country name."
            },
            iso: {
                required: "Please enter iso code",
                minlength: "Please enter min 2 alphabets",
                maxlength: "Please enter max 2 alphabets"
            },
            digit:{
                required:"Please enter digits",
                minlength:"Please enter atleast 1 digit",
                maxlength:"Please enter atmost 1 digit"
            },
            pattern:{
                required:"Please select pattern"
            }
        },
        submitHandler: function (form) {

            form.submit();
        }
    });
    jQuery("#create_faq").validate({
        errorClass: 'text-danger',
        rules: {
            question: {
                required: true,
                alphaSpace: true
            },
            answer: {
                required: true,
                alphaSpace: true
            }
        },
        messages: {
            question: {
                required: "Please enter question."

            },
            answer: {
                required: "Please enter answer"
            }

        },
        submitHandler: function (form) {

            form.submit();
        }
    });

    jQuery("#update_faq").validate({
        errorClass: 'text-danger',
        rules: {
            question: {
                required: true,
                alphaSpace: true
            },
            answer: {
                required: true,
                alphaSpace: true
            }
        },
        messages: {
            question: {
                required: "Please enter question."

            },
            answer: {
                required: "Please enter answer"
            }

        },
        submitHandler: function (form) {

            form.submit();
        }
    });
});
jQuery("#create_box").validate({
    highlight: false,
    errorElement: 'div',
    rules: {
        box_name: {
            required: true,
            alphaSpace: true
        },
        image: {
            required: true
        },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        },
        status: {
            required: true
        },
        order_quantity: {
            required: true,
            digits: true,
            maxlength: 5,
            min: 1
        }

    },
    messages: {
        name: {
            required: "Please select box name"
        },
        image: {
            required: "Please select box image."
        },
        price: {
            required: "Please enter box amount.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        },
        status: {
            required: "Please select status."
        },
        order_quantity: {
            required: "please enter box quantity",
            digits: "Please enter numbers only",
            maxlength: "Please enter quantity upto than 5 digit",
            min: "Please enter quantity greater than 1"
        }
    },
    submitHandler: function (form) {
        $("#btn_product").hide();
        form.submit();
    }
});
jQuery("#update_box").validate({
    highlight: false,
    errorElement: 'div',
    rules: {
        box_name: {
            required: true,
            alphaSpace: true
        },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        },
        status: {
            required: true
        }
        // order_quantity: {
        //     required: true,
        //     digits: true,
        //     maxlength: 5,
        //     min: 1
        // }

    },
    messages: {
        name: {
            required: "Please select box name"
        },
        price: {
            required: "Please enter box amount.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        },
        status: {
            required: "Please select status."
        }
        // order_quantity: {
        //     required: "please enter box quantity",
        //     digits: "Please enter numbers only",
        //     maxlength: "Please enter quantity upto than 5 digit",
        //     min: "Please enter quantity greater than 1"
        // }

    },
    submitHandler: function (form) {
        $("#btn_product").hide();
        form.submit();
    }
});
jQuery("#create_paper").validate({
    highlight: false,
    errorElement: 'div',
    rules: {
        paper_name: {
            required: true,
            alphaSpace: true
        },
        image: {
            required: true
        },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        },
        status: {
            required: true
        }
        // order_quantity: {
        //     required: true,
        //     digits: true,
        //     maxlength: 5,
        //     min: 1
        // }


    },
    messages: {
        paper_name: {
            required:"Please enter Paper Name"
        },
        image: {
            required: "Please select paper image."

        },
        price: {
            required: "Please enter paper amount.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        },
        status: {
            required: "Please select status."
        }
        // order_quantity: {
        //     required: "please enter paper quantity",
        //     digits: "Please enter numbers only",
        //     maxlength: "Please enter quantity upto than 5 digit",
        //     min: "Please enter quantity greater than 1"
        // }
    },
    submitHandler: function (form) {
        $("#btn_product").hide();
        form.submit();
    }
});
jQuery("#update_paper").validate({

    highlight: false,
    errorElement: 'div',
    rules: {
        paper_name: {
            required: true,
            alphaSpace: true
        },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        },
        status: {
            required: true
        },
        order_quantity: {
            required: true,
            digits: true,
            maxlength: 5,
            min: 1
        }
    },
    messages: {
        paper_name: {
            required: "Please enter paper name"
        },
        price: {
            required: "Please enter paper amount.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        },
        status: {
            required: "Please select status."
        },
        order_quantity: {
            required: "please enter paper quantity",
            digits: "Please enter numbers only",
            maxlength: "Please enter quantity upto than 5 digit",
            min: "Please enter quantity greater than 1"
        }

    },
    submitHandler: function (form) {
        $("#btn_product").hide();
        form.submit();
    }
});
jQuery("#create_display").validate({
    highlight: false,
    errorElement: 'div',
    rules: {
        display_name: {
            required: true,
            alphaSpace: true
        },
        display_weight: {
            required: true,
            floatOnly: true,
            maxlength: 5,
            min: 0.01
        },
        image: {
            required: true
        },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        },
        status: {
            required: true
        }
        // order_quantity: {
        //     required: true,
        //     digits: true,
        //     maxlength: 5,
        //     min: 1
        // }

    },
    messages: {
        display_name: {
            required: "Please select display name"
        },
        display_weight: {
            required: "Please enter display weight.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter weight value upto 5 digits",
            min: "Please enter value greater than 0.01"
        },

        image: {
            required: "Please select display image."
        },
        price: {
            required: "Please enter display amount.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        },
        status: {
            required: "Please select status."
        }
        // order_quantity: {
        //     required: "please enter display quantity",
        //     digits: "Please enter numbers only",
        //     maxlength: "Please enter quantity upto than 5 digit",
        //     min: "Please enter quantity greater than 1"
        // }
    },
    submitHandler: function (form) {
        $("#btn_product").hide();
        form.submit();
    }
});
jQuery("#update_display").validate({
    highlight: false,
    errorElement: 'div',
    rules: {
        display_name: {
            required: true,
            alphaSpace: true
        },
        display_weight: {
            required: true,
            floatOnly: true,
            maxlength: 5,
            min: 0.01
        },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        },
        status: {
            required: true
        }
        // order_quantity: {
        //     required: true,
        //     digits: true,
        //     maxlength: 5,
        //     min: 1
        // }

    },
    messages: {
        display_name: {
            required: "Please select display name"
        },
        display_weight: {
            required: "Please enter display weight.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 5 digits",
            min: "Please enter value greater than 0.01"
        },
        price: {
            required: "Please enter display amount.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        },
        status: {
            required: "Please select status."
        }
        // order_quantity: {
        //     required: "please enter box quantity",
        //     digits: "Please enter numbers only",
        //     maxlength: "Please enter quantity upto than 5 digit",
        //     min: "Please enter quantity greater than 1"
        // }

    },
    submitHandler: function (form) {
        $("#btn_product").hide();
        form.submit();
    }
});




jQuery("#update-global-settings-form").validate({
    errorClass: 'text-danger',
    rules: {
        banner_type: {
            required: true
        },
        banner_image: {
            required: true
        },
        banner_video: {
            required: true
        }
    },
    messages: {
        banner_type: {
            required: "Please select banner type"
        },

        banner_image: {
            required: "Please select banner image"
        },
        banner_video: {
            required: "Please select banner video"
        }
    },
    submitHandler: function (form) {
        form.submit();
    }
});
jQuery("#create-role").validate({
    errorClass: 'text-danger',
    rules: {
        name: {
            required: true,
            alphaSpace:true
        },
        slug: {
            required: true,
            alphaSpace:true
        }
    },
    messages: {
        name: {
            required: "Please select role type"
        },

        slug: {
            required: "Please select role slug"
        }
    },
    submitHandler: function (form) {
        form.submit();
    }
});

jQuery("#create_gift_card").validate({
    errorClass: 'text-danger',
    rules: {
        card_name: {
            required: true,
            alphaSpace:true
        },
        image:
            {
                required: true
            },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        }
    },
    messages: {
        card_name: {
            required: "Please enter gift card name."
        },
        image: {
            required: "Please choose gift card image."
        },
        price: {
            required: "Please enter minimum price.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        }
    },
    submitHandler: function (form) {

        form.submit();
    }
});

jQuery("#update_gift_card").validate({
    errorClass: 'text-danger',
    rules: {
        card_name: {
            required: true,
            alphaSpace:true
        },
        price: {
            required: true,
            floatOnly: true,
            maxlength: 7,
            min: 1
        }
    },
    messages: {
        card_name: {
            required: "Please enter gift card name."
        },
        price: {
            required: "Please enter minimum price.",
            floatOnly: "Please enter numbers only",
            maxlength: "Please enter amount value upto 7 digits",
            min: "Please enter value greater than 1"
        }
    },
    submitHandler: function (form) {

        form.submit();
    }
});
jQuery("#create-artist").validate({
    errorClass: 'text-danger',
    rules: {
        first_name: {
            required: true,
            alphaSpace:true
        },
        last_name: {
            required: true,
            alphaSpace:true
        },
        artist_email:
            {
                required: true,
                email: true
                // remote: {
                //     url: javascript_site_path + 'chk-artist-email-duplicate',
                //     method: 'get'
                // }
            },
        number: {
            minlength: 10,
            maxlength: 12
        },
        description:{
            required:true
        },
        youtube_link:{
            required:true
        },
        facebook_id:{
            required:true
        },
        instagram_id:{
            required:true
        },
        linkedin_id:{
            required:true
        },
        twitter_id:{
            required:true
        },
        'services[]':{
            required:true
        },
        profile_image:{
            required:true
        },
        country_flag:{
            required:true
        },
        video:{
            required:true
        },
        'images[]':{
            required:true
        }

    },
    messages: {
        first_name: {
            required: "Please enter first name"
        },
        last_name: {
            required: "Please enter last name"
        },
        artist_email:
            {
                required: "Please enter email id",
                email: "Please enter valid email id"
                // remote: "This email is already taken"
            },
        number: {
            minlength: "Please enter at least 10 digit number.",
            maxlength: "Please enter atmost 12 digit number."
        },
        description:{
            required:"Plese enter description"
        },
        youtube_link:{
            required:"Plese enter youtube link"
        },
        facebook_id:{
            required:"Please enter facebook id"
        },
        instagram_id:{
            required:"Please enter instagram id"
        },
        linkedin_id:{
            required:"Please enter linked In id"
        },
        twitter_id:{
            required:"Please enter twitter id"
        },
        'services[]':{
            required:"Please enter services"
        },
        profile_image:{
            required:"Please choose profile image"
        },
        country_flag:{
            required:"Please choose country flag"
        },
        video:{
            required:"Please select video"
        },

        'images[]':{
            required:"Please choose images"
        }
    },
    submitHandler: function (form) {
        form.submit();
    }
});




function appendErrorMsgProduct() {

    setTimeout(function () {

        jQuery(".multiselect-native-select label.text-danger").insertAfter(jQuery(".multiselect-native-select label.text-danger").parent());

    }, 100);


}

function appendErrorMsgCoupen() {

    setTimeout(function () {

        jQuery("[for='radioChange']").insertAfter(jQuery("[for='radioChange']").parents("ul"))

    }, 100);

}
function appendErrorMsgDiscount(){
    setTimeout(function () {

        jQuery("label[for='discount_valid_to']").insertAfter(jQuery("#datepicker2"));
        jQuery("label[for='discount_valid_from']").insertAfter(jQuery("#datepicker1"));

    }, 100);
}


