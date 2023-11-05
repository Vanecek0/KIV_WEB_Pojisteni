jQuery(function () {
    $("#portal-register").on('submit', (function (event) {
        var formData = {
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            phone: $("#phone").val(),
            email: $("#email").val(),
            birth: $("#birth").val(),
            birth_number: $("#birth_number").val(),
            city: $("#city").val(),
            street: $("#street").val(),
            psc: $("#psc").val(),
            username: $("#username").val(),
            password: $("#password").val(),
            gdpr: $("#gdpr").val(),
            terms: $("#terms").val(),
        };

        var url = '/register/post';

        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (response) {
                var json_response = JSON.parse(response);
                $("#register-message").text(json_response.register_message);
                $("#register-error").text(json_response.register_error);
            },
            error: function (xhr, status, error) {
                alert('Error :' +  error)
            }
        });
    }));
});