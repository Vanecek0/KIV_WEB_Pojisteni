function deleteRow(id) {
    $.ajax({
        url: 'http://pojisteni.localhost.com/insurances/delete',
        data: { id },
        dataType: 'json',
        success: function (data) {
            $('#insurancesTable tr[insurance-id="' + id + '"]').remove();
            return true;
        }
    });
}