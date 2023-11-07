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
            success: function (response) {
                if(response == 1) {
                    window.location = this.url;
                }
                var json_response = JSON.parse(response);
                $("#login-message").text(json_response.login_message);
                $("#login-error").text(json_response.login_error);
            },
            error: function (xhr, status, error) {
                alert('Error :' + error)
            }
        });
        event.preventDefault();
    }));
});