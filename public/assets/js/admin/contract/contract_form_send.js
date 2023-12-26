jQuery(function () {
    $("#contract_edit_form").on('submit', (function (event) {
      event.preventDefault();
      var formData = {};
      $('#rowData input, #rowData select, #rowData textarea').each(function () {
        formData[$(this).attr('name')] = $(this).val();
      });

      $.ajax({
        url: 'http://pojisteni.localhost.com/insurance-contracts/update',
        data: formData,
        success: function (response) {
          var contractId = $('[name="id"]').val();
          var $tableRow = $(`#contractsTable tr[contract-id="${contractId}"]`);

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