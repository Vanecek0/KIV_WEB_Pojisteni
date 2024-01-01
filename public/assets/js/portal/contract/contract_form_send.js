jQuery(function () {
    $("#new-contract").on('submit', (function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/portal/new/contract/post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                var json_response = JSON.parse(response);
                $("#contract-message").text(json_response.contract_message);
                $("#contract-error").text(json_response.contract_error);

                if(json_response.contract_message) {
                    alert(json_response.contract_message);
                }

                if(!json_response.contract_error) {
                    window.location = this.url;
                } else {
                    alert(json_response.contract_error);
                }

                
            },
            error: function (xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }));
});
