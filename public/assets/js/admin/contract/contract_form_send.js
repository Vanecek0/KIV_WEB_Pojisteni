jQuery(function () {
    $("#contract_edit_form").on('submit', (function (event) {
      event.preventDefault();
      var formData = {};
      $('#rowData input, #rowData select').each(function () {
        formData[$(this).attr('name')] = $(this).val();
      });

      $.ajax({
        url: 'http://pojisteni.localhost.com/contracts/update',
        data: formData,
        success: function (response) {
          var userId = $('[name="id"]').val();
          var $tableRow = $(`#contractsTable tr[contract-id="${userId}"]`);

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