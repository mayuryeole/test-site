jQuery(document).ready(function() {

    jQuery.validator.addMethod("allZero", function(value, element) {
        if (value > 0)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid name");

    jQuery.validator.addMethod("zipAlphaNum", function (value, element) {
        var isNum = $("#ship-ctry-pattern").val();
        if(isNum == "1") {
            return this.optional(element) || /^[a-zA-Z0-9]*$/.test(value);
        }
        else if(isNum == "0"){
            return this.optional(element) || /^[0-9]*$/.test(value);
        }
    }, "Please enter a valid postal code.");

    jQuery.validator.addMethod("floatOnly", function (value, element) {
        return this.optional(element) || /^[+]?\d+(\.\d+)?$/.test(value);
    });

    jQuery.validator.addMethod("phoneNumber", function(value, element) {
        if (value != "" && value > 0 && value.length == 10)
        {
            return true;

        } else {
            return false;
        }

    }, "Please enter 10 digit mobile number");

    jQuery.validator.addMethod("zipcode", function(value, element) {
        if (value != "" && value > 0 && value.length == 6)
        {
            return true;

        } else {
            return false;
        }

    }, "Please enter 6 digit zip number");


    jQuery.validator.addMethod("gstNumber", function(value, element) {
        if (value != "" && value > 0 && value.length == 15)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid GST number");

    jQuery.validator.addMethod("panNumber", function(value, element) {
        if (value != "" && value > 0 && value.length == 10)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid PAN Card number");

    jQuery.validator.addMethod("tax_id", function(value, element) {
        if (value != "" && value > 0 && value.length == 9)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid Tax Id");


    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");

    jQuery.validator.addMethod("intlTelNumber", function(value, element) {
        return this.optional(element) || $(element).intlTelInput("isValidNumber");
    }, "Please enter a valid International Phone Number");

    jQuery.validator.addMethod("alphaSpace", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, 'Name only contains alphabets and space');


    /* landing Form Validation Start */
    jQuery("#register_normal").validate({
        errorClass: 'text-danger',
        rules: {
            first_name:{
                required: true,
                lettersonly: true
            },
            last_name: {
                required: true,
                lettersonly: true

            },
            email:{
                required: true,
                email: true,
                remote: {
                    url: javascript_site_path + 'chk-email-duplicate',
                    method: 'get'
                }
            },
            password:{
                required: true,
                minlength: 6
            },
            password_confirmation:{
                required: true,
                equalTo: "#password"
            },
            user_country: {
                required: true
            },
            user_mobile: {
                minlength: 10,
                maxlength: 10
            },
            pancard_no: {
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
            user_country: {
                required: "Please select country"
            },
            user_mobile: {
                minlength: "Please enter 10 digit mobile number.",
                maxlength: "Please enter 10 digit mobile number."
//                required: "Please enter mobile number.",


            },
            pancard_no: {
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
        submitHandler: function(form) {
            // jQuery("#btn_register").hide();
            // jQuery("#btn_loader").show();
            if ($("#user_country").val() == '3')
            {

//                alert("in if");return false;
                user_mobile = $("#user_mobile").val();
                if (user_mobile != "" && user_mobile > 0 && user_mobile.length == 10)   // Choose Mobile Number here
                {
//                    $("#no_mobile").hide();
                    form.submit();
                } else {
//                    $("#user_mobile").focus();
                    $("#no_mobile").show();
//                    alert("Please Enter 10 digit mobile number.");
                    return false;
                }
            } else {
                $('#btn_register').attr('disabled',true);
//                alert("in else");return false;
                form.submit();
            }
        }
    });


    /* landing Form Validation Start */
    jQuery("#business_register_normal").validate({
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
                    required: function() {
                        return $("#password").val() != '';
                    },
                    equalTo: "#password"
                },
            user_country: {
                required: true
            },
            user_mobile: {
                required: true,
//                minlength:10,
//                maxlength:10,
                phoneNumber: true
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
            user_country: {
                required: "Please select country"
            },
            user_mobile: {
                required: "Please enter mobile number",
                phoneNumber: true
            }

        },
        submitHandler: function(form) {
            // jQuery("#btn_register").hide();
            // jQuery("#btn_loader").show();
            form.submit();
        }
    });
    /* landing Form Validation Start */
    jQuery("#update_profile").validate({
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
            user_mobile: {
//                required: true,
                minlength: 10,
                maxlength: 10
//                phoneNumber: true
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
                // specialChars: "Please enter a valid email.",
                email: "Please enter a valid email."
                // remote: "This email address is already registered with site."
            },
            password: {
                required: "Please enter a password."
            },
            password_confirmation: {
                required: "Please confirm above password.",
                equalTo: "These passwords don't match. Try again!!"
            },
            user_mobile: {
//                required: "Please",
                minlength: "Please enter 10 digit mobile number",
                maxlength: "Please enter 10 digit mobile number"
//                phoneNumber: true
            },
            zipcode: {
                required: "Please enter postcode."
            },
            user_description_type: {
                required: "Please select an option."
            }

        }
    });

    $("#track-order-form").validate({
        errorClass: 'text-danger',
        rules: {
            tracking_id: {
                required: true,
                digits: true
            }
        },
        messages: {
            shipping_name: {
                required: "Please enter Tracking id",
                digits:"Please enter digits only"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    // customer-shipping-details-form
    $("#shipping-details-form").validate({
        errorClass: 'text-danger',
        rules: {
            shipping_name:{
                required: true,
                alphaSpace: true
            },
            shipping_email:{
                required: true,
                email: true
            },
            country:{
                required: true
            },
            house_no:
                {
                    required: true
                },
            city:
                {
                    required: true
                },
            telephone:
                {
                    required: true,
                    intlTelNumber:true
                },
            postal_code:
                {
                    required:true,
                    minlength: function(){
                        return $('#ship-ctry-digits').val();
                    },
                    maxlength: function(){
                        return $('#ship-ctry-digits').val();
                    },
                    zipAlphaNum: true
                },
            region:{
                required: true
            },
            billing_name:{
                required: true,
                alphaSpace: true
            },
            billing_email:{
                required: true,
                email: true
            },
            billing_country:{
                required: true
            },
            billing_house_no:{
                required: true
            },
            billing_city:{
                required: true
            },
            billing_postal_code:{
                required:true,
                minlength:4,
                maxlength:6
            },
            billing_region:{
                required:true
            },
            billing_telephone:{
                required: true,
                intlTelNumber:true
            }
        },
        messages: {
            shipping_name:{
                required: "Please enter Shipping name"
            },
            shipping_email:{
                required: "Please enter Shipping email id",
                email: "Please enter valid email id"
            },
            country:{
                required:"Please select country"
            },
            house_no:
                {
                    required: "Please enter house no and street"
                },
            city:
                {
                    required: "Please select city"
                },
            telephone:
                {
                    required: "Please enter mobile number"
                },
            postal_code:
                {
                    required: "Please enter postal code"
                },
            region:{
                required:"Please select region"
            },
            billing_name:{
                required: "Please enter Billing name"
            },
            billing_email:{
                required: "Please enter Billing email id",
                email: "Please enter valid email id"
            },
            billing_country:{
                required: "Please select Billing country"
            },
            billing_house_no:{
                required: "Please enter Billing house no and street"
            },
            billing_city:{
                required: "Please select Billing city"
            },
            billing_postal_code:
                {
                    required: "Please enter postal code",
                    minlength:"Please enter at least 4 digit postal code",
                    maxlength:"Please enter at most 6 digit postal code"
                },
            billing_region:{
                required: "Please select Billing region"
            },
            billing_telephone:{
                required: "Please enter  Billing mobile name"
            }

        },
        submitHandler: function(form)
        {
            if($('#shipping-zip').val().length != $('#ship-ctry-digits').val())
            {
                alert("");
                return false;
            }
            form.submit();
        }
    });
    $("#customer-shipping-details-form").validate({
        errorClass: 'text-danger',
        rules: {
            name_initial:{
                required: true
            },
            first_name:
                {
                    required: true,
                    lettersonly:true
                },
            last_name: {
                required: true,
                lettersonly:true
            },
            email: {
                required: true,
                email: true
            },
            confirm_email: {
                required: true,
                email: true,
                equalTo: "#email"
            }
        },
        messages: {
            name_initial:{
                required:"Please select title"
            },
            first_name: {
                required: "Please enter first name."
            },
            last_name: {
                required: "Please enter last name."
            },
            email: {
                required: "Please enter email.",
                email: "Please enter valid email."
            },
            confirm_email: {
                required: "Please enter email.",
                email: "Please enter valid email.",
                equalTo: "confirm_email must be same as email"
            }
        },
        submitHandler: function(form) {

            form.submit();
        }
    });
    /* landing Form Validation Start */
    jQuery("#update_email").validate({
        errorClass: 'text-danger',
        rules: {
            email:
                {
                    required: true,
                    email: true
                },
            confirm_email: {
                required: true,
                email: true,
                equalTo: "#email"
            }


        },
        messages: {
            email: {
                required: "Please enter an email.",
                specialChars: "Please enter a valid email.",
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
                    remote: "Record is not matching in our system"
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

    jQuery("#form1").validate({
        errorClass: 'text-danger',
        rules: {
            business_password: {
                required: true,
                minlength: 6
            },
            business_email: {
                required: true,
                email: true
            }
        },
        messages: {
            business_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            business_email: "Please enter a valid email address"
        },
        submitHandler: function(form) {
            // do other things for a valid form
            //alert("sagsfdh");return false;
            form.submit();
        }

    });

    jQuery("#form2").validate({
        errorClass: 'text-danger',
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            email: "Please enter a valid email address"
        },
        submitHandler: function(form) {
            form.submit();
        }

    });

    jQuery("#cust-artist-appointment").validate({
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
            email: {
                required: true,
                email: true
            },
            mobile:{
                required: true,
                minlength: 10,
                maxlength: 10
            },
            valid_from:{
                required: true
            },
            description:{
                required: true
            }
        },
        messages: {

            first_name: {
                required: "Please enter first name"
            },
            last_name: {
                required: "Please enter last name"
            },
            email: {
                required: "Please enter email id",
                email: "Please enter valid email id"
            },
            mobile:{
                required: "Please enter mobile number",
                minlength: "Please enter 10 digit mobile number",
                maxlength: "Please enter 10 digit mobile number"
            },
            valid_from:{
                required: "Please enter date"
            },
            description:{
                required: "Please enter description"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
    jQuery("#purchase-gift-card-form").validate({
        errorClass: 'text-danger',
        rules: {
            amount: {
                required: true,
                floatOnly: true,
                min: $("#min-purchase-amt").val(),
                maxlength: 7
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            amount: {
                required: "Please enter a amount",
                floatOnly: "Please enter numbers only",
                min: "Please enter amount greater than " + $("#min-purchase-amt").val(),
                maxlength: "Please enter amount value upto 7 digits"

            },
            email:{
                required:"Please enter a email id",
                email:"Please enter valid email id"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }

    });



    jQuery("#myform").validate({
        errorClass: 'text-danger',
        rules: {
            name:
                {
                    required: true
                },
            email:
                {
                    required: true,
                    email: true
                },
            phone:
                {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    phoneNumber: true

                },
            category:{
                required:true
            },
            subject:
                {
                    required: true
                },
            message: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Please enter name.",
                lettersonly:true
            },
            email: {
                required: "Please enter email.",
                email: "Please enter valid email."
            },
            phone: {
                required: "Please enter mobile number",
                minlength: 'Please enter 10 digit mobile number',
                maxlength: 'Please enter 10 digit mobile number',
                phoneNumber: "Please enter valid mobile number"
            },
            category: {
                required: "Please select enquiry type"
            },
            subject: {
                required: "Please enter subject."
//                minlength: "Please enter minimum 6 characters."
            },
            message: {
                required: "Please enter message."
//                equalTo: "Confirm password is not matching with above password entered."
            },
        },
        submitHandler: function(form) {
            // jQuery("#btn_register").hide();
            // jQuery("#btn_loader").show();
            form.submit();
        }
    });


    $("#user_mobile").keydown(function(){
        $("#no_mobile").hide()

    })
});
