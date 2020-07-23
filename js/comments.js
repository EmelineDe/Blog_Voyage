$('#commentsform').submit(function (e) {
    event.preventDefault();
    var data = $("#commentsform").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "addcom.php",
        success: function (data) {
            $('#comment').val('');
            window.location.reload();
        }
    });
});




