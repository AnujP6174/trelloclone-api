$(document).ready(function () {
    $.validator.addMethod("regex", function (value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    });
    $.validator.addMethod("needsSelection", function (value, element) {
        var count = $(element).find("option:selected").length;
        return length > 0;
    });
    $("form").submit(function () {
        var options = $("#emp > option:selected");
        if (options.length == 0) {
            ("Please select any one employee");
            return false;
        }
    });

    // add task
    $("#addtask").validate({
        rules: {
            title: {
                required: true,
                maxlength: 100,
            },
            description: {
                required: true,
                maxlength: 800,
            },
            // "emp[]": {
            //     needsSelection: true,
            //     agree: "required",
            //     required: true,
            // },
            "emp[]": { required: true },
            deadline: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please Enter Title",
                maxlength: "Maximum 100 characters are allowed",
            },
            description: {
                required: "Please Enter Description",
                maxlength: "Maximum 800 characters are allowed",
            },
            // "emp[]": {
            //     needsSelection: "Select any one",
            //     agree: "",
            //     required: "Please Select any one employee",
            // },
            "emp[]": "please select",
            deadline: {
                required: "Please select the due date",
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
});
