jQuery(function () {
    $("#portal-login").on('submit', (function (event) {
        var formData = {
            username: $("#username").val(),
            password: $("#password").val(),
        };
        var url = '/login/post';

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function () {
                window.location = this.url;
            },
            error: function (xhr, status, error) {
                alert('Error :' +  error)
            }
        });
        event.preventDefault();
    }));
});