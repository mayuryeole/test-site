jQuery(document).ready(function () {

    jQuery.validator.addMethod("allZero", function (value, element) {
        if (value > 0)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid name");

    jQuery.validator.addMethod("phoneNumber", function (value, element) {
        if (value != "" && value > 0 && value.length == 10)
        {
            return true;

        } else {
            return false;
        }

    }, "Please enter 10 digit mobile number");

    jQuery.validator.addMethod("zipcode", function (value, element) {
        if (value != "" && value > 0 && value.length == 6)
        {
            return true;

        } else {
            return false;
        }

    }, "Please enter 6 digit zip number");


    jQuery.validator.addMethod("gstNumber", function (value, element) {
        if (value != "" && value > 0 && value.length == 15)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid GST number");

    jQuery.validator.addMethod("panNumber", function (value, element) {
        if (value != "" && value > 0 && value.length == 10)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid PAN Card number");

    jQuery.validator.addMethod("tax_id", function (value, element) {
        if (value != "" && value > 0 && value.length == 9)
        {
            return true;
        } else {
            return false;
        }

    }, "Please enter valid Tax Id");


    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");

    jQuery.validator.addMethod("intlTelNumber", function (value, element) {
        return this.optional(element) || $(element).intlTelInput("isValidNumber");
    }, "Please enter a valid International Phone Number");

    jQuery.validator.addMethod("alphaSpace", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, 'Name only contains alphabets and space');

    jQuery("#book_business_appointment").validate({
        errorClass: 'text-danger',
        rules: {
            first_name:
                    {
                        required: true,
                        lettersonly: true
                    },
            email:
                    {
                        required: true,
                        email: true,
                    },
            facetime_or_skype_id:
                    {
                        required: true
                    },
            facetime_or_skype_name:
                    {
                        required: true
                    },
            purpose_of_appointment:
                    {
                        required: true
                    },
            calendar:
                    {
                        required: true
                    },
            phone: {
                phoneNumber: true,
                required:true,
            }
        },
        messages: {
            first_name: {
                required: "Please enter first name."
            },
            email: {
                required: "Please enter email.",
                email: "Please enter valid email."
            },
            facetime_or_skype_id:
                    {
                        required: "Select your mode of contact Id"
                    },
            facetime_or_skype_name:
                    {
                        required: "Enter your Id.eg:facetime,skype."
                    },
            purpose_of_appointment:
                    {
                        required: "Please describe your purpose of appointment."
                    },
            calendar:
                    {
                        required: "Please select date."
                    },
            phone: {
                required:"Please Enter your phone number"
            }

        },
        submitHandler: function (form) {
            $("#business_submit_button").attr('disabled','true');
            form.submit();
        }
    });


});
