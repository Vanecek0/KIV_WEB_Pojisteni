jQuery(function () {
    $("#new-contract").on('submit', (function (event) {
        var formData = {
            vehicle: $('[name="vehicle"]').val(),
            spz: $('[name="spz"]').val(),
            insurer: $('[name="insurer"]').val(),
            ico: $('[name="ico"]').val(),
            dic: $('[name="dic"]').val(),
            firstname: $('[name="firstname"]').val(),
            lastname: $('[name="lastname"]').val(),
            birth: $('[name="birth"]').val(),
            birth_number: $('[name="birth-number"]').val(),
            phone_number: $('[name="phone-number"]').val(),
            email: $('[name="email"]').val(),
            city: $('[name="city"]').val(),
            street: $('[name="street"]').val(),
            psc: $('[name="psc"]').val(),
        };
        var url = '/portal/new/contract/post';

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (response) {
                if(response == 1) {
                    alert(response);
                }
                //var json_response = JSON.parse(response);
                alert(response);
                /*$("#login-message").text(json_response.login_message);
                $("#login-error").text(json_response.login_error);*/
            },
            error: function (xhr, status, error) {
                alert('Error :' + error)
            }
        });
        event.preventDefault();
    }));
});