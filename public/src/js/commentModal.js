var userId = 0;
var taskId = 0;
$(document).ready(function () {
    $(".commentbtn").click(function (event) {
        event.preventDefault();
        userId = event.target.dataset["user"];
        taskId = event.target.dataset["task"];
        $("#cmntmodal").modal("show");
    });

    $("#modalsave").click(function () {
        $.ajax({
            method: "POST",
            url: urlComment,
            data: {
                userId: userId,
                taskId: taskId,
                comment: $("#comment").val(),
                _token: token,
            },
            success: function (response) {
                getComment();
                $("#cmntmodal").modal("hide");
                $("#cmntmodal form :input").val("");
                // $(".web").html(response);
                // comment($(".test"));
                // alert("Comment Added");
                // window.location.reload();
            },
            error: function (error) {
                console.log(error);
                alert("Comment not added");
            },
        });
    });
});
