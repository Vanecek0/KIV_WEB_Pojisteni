jQuery(function () {
    $("#new-insurance").on('submit', (function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/portal/new/insurance-events/post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                var json_response = JSON.parse(response);

                if(json_response.insurance_message) {
                    alert(json_response.insurance_message);
                }

                if(!json_response.insurance_error) {
                    window.location = this.url;
                } else {
                    alert(json_response.insurance_error);
                }

            },
            error: function (xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }));
});
