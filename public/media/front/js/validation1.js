jQuery(document).ready(function() {


    /* landing Form Validation Start */
    jQuery("#register_normal").validate({
    
        errorClass: 'text-danger',
        rules: {
            first_name: 
            {
                required: true
            },
            
            email: 
            {
                required: true,
                email:true,
                remote: {
                        url: javascript_site_path + 'chk-email-duplicate',
                        method: 'get'
                    }
                
            },
            
            password: 
            {
                required: true,
                minlength:6
            },
            password_confirmation: 
            {
                required:function(){
                    return $("#password").val()!='';
                },
                equalTo:"#password"
            },
            
            last_name: {
                required: true
            },
          
            suburb: {
                required: true
            },
            zipcode: {
                required: true
            },
            user_description_type: {
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
            email:{
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote:"This email is already taken"
            },
           
            password: {
                required: "Please enter password.",
                minlength: "Please enter minimum 6 characters."
            },
            password_confirmation: {
                required: "Please enter confirm password.",
                equalTo: "Confirm password is not matching with above password entered."
            },
            suburb: {
                required: "Please enter suburb."
            },
           
            zipcode: {
                 required: "Please enter postcode.",
            },
            user_description_type: {
                 required: "Please select an option.",
            }            
            
        },
        submitHandler: function(form) {
            jQuery("#btn_register").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
    /* landing Form Validation Start */
    jQuery("#update_profile").validate({
    
        errorClass: 'text-danger',
        rules: {
            first_name: 
            {
                required: true
            },
            
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true
//                remote: {
//                    url: javascript_site_path + 'chk-email-duplicate',
//                    method: 'post'
//                }
            },
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: 
            {
                required: true,
                equalTo: "#password"
            },
            suburb: {
                required: true
            },
            zipcode: {
                required: true
            },
            user_description_type: {
                required: true
            }
           
        },
        messages: {
            first_name: {
                required: "Please enter the first name."
            },
            last_name: {
                required: "Please enter the last name."
            },
            suburb: {
                required: "Please enter suburb."
            },
            email: {
                required: "Please enter an email.",
                specialChars:"Please enter a valid email.",
                email: "Please enter a valid email.",
                remote: "This email address is already registered with site."
            },
            password: {
                required: "Please enter a password.",
                
            },
            password_confirmation: {
                required: "Please confirm above password.",
                equalTo: "These passwords don't match. Try again!!"
            },
            zipcode: {
                 required: "Please enter postcode.",
            },
            user_description_type: {
                 required: "Please select an option.",
            }            
            
        }
    });
    /* landing Form Validation Start */
    jQuery("#update_email").validate({
    
        errorClass: 'text-danger',
        rules: {
            email: 
            {
                required: true,
                email:true
            },
            
            confirm_email: {
                required: true,
                email:true,
                equalTo: "#email"
            }
          
           
        },
        messages: {
         
            email: {
                required: "Please enter an email.",
                specialChars:"Please enter a valid email.",
                email: "Please enter a valid email.",
                remote: "This email address is already registered with site."
            },
            confirm_email: {
                required: "Please enter confirm email.",
                email: "Please enter a valid email."
            }
            
        }
    });
    /* landing Form Validation Start */
    jQuery("#update_password").validate({
    
        errorClass: 'text-danger',
        rules: {
            current_password: 
            {
                required: true,
                remote: {
                        url: javascript_site_path + 'chk-current-password',
                        method: 'get'
                    }
            },
            
            new_password: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
          
           
        },
        messages: {
         
           current_password: 
            {
                required: "Please enter your current password.",
                remote  : "Record is not matching in our system"
            },
            new_password: {
                 required: "Please enter new password.",
            },
            confirm_password: {
                required: "Please enter confirm password.",
                equalTo: "Please enter same password as above.",
            }
           
            
        }
    });

 

       
});
