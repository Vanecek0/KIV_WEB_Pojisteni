jQuery(function () {
    $("#user_edit_form").on('submit', (function (event) {
      event.preventDefault();
      var formData = {};
      $('#rowData input, #rowData select').each(function () {
        formData[$(this).attr('name')] = $(this).val();
      });

      $.ajax({
        url: '/users/update',
        data: formData,
        success: function (response) {
          if(response.hasOwnProperty('message')) {
            alert(response.message);
          }
          var userId = $('[name="id"]').val();
          var $tableRow = $(`#clientsTable tr[user-id="${userId}"]`);

          $tableRow.find('td').each(function () {
            var columnName = $(this).index();
            var dataKey = Object.keys(formData)[columnName];
            if (formData.hasOwnProperty(dataKey)) {
              $(this).text(formData[dataKey]);
            }
          });
        },
        error: function (xhr, status, error) {
          alert('Error: ' + error);
        }
      });
    }));
  });