jQuery(function () {
    $("#insurance_edit_form").on('submit', (function (event) {
      event.preventDefault();
      var formData = {};
      $('#rowData input, #rowData select, #rowData textarea').each(function () {
        formData[$(this).attr('name')] = $(this).val();
      });

      $.ajax({
        url: '/insurances/update',
        data: formData,
        success: function (response) {
          var insuranceId = $('[name="id"]').val();
          var $tableRow = $(`#insurancesTable tr[insurance-id="${insuranceId}"]`);

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