$(document).ready(function (e) {
    $("#searchCountry").keyup(function () {
        $.ajax({
            type: "GET",
            url: "searchCountry.php",
            data: 'keyword=' + $(this).val(),
            success: function (data) {
                $("#show_up").show();
                $("#show_up").html(data);
            }
        });
    });
});








