$(document).ready(function () {
    jQuery.validator.addMethod(
        "lettersonly",
        function (value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        },
        "Only alphabetical characters"
    );

    $.validator.addMethod("regex", function (value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    });

    // SIGNUP
    $("#usersignup").validate({
        rules: {
            name: {
                required: true,
                maxlength: 50,
                lettersonly: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                regex: "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@])(?=.{8,})",
            },
            cpassword: {
                required: true,
                equalTo: "#password",
            },
        },
        messages: {
            name: {
                required: "Please Enter Your Name",
                maxlength: "Maximum 50 characters are allowed",
                lettersonly: "Name should be alphabets only",
            },
            email: {
                required: "Please Enter Email",
                email: "Email should contain @,should have alphabets after .",
            },
            password: {
                required: "Please Enter Password",
                regex: "Password must contain lower,upper,numbers,special characters and should be 8 characters long",
            },
            cpassword: {
                required: "Please Enter Password Again",
                equalTo: "Confirm Password must be same as Password",
            },
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.addClass("invalid-feedback");
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
    // login
    $("#userlogin").validate({
        rules: {
            email: {
                required: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "Please Enter Email",
            },
            password: {
                required: "Please Enter Password",
            },
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.addClass("invalid-feedback");
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
});
