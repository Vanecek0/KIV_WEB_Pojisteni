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
                if (response === '1') {
                    alert('Success: ' + response);
                } else {
                    alert('Error: ' + response);
                }
            },
            error: function (xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }));
});
