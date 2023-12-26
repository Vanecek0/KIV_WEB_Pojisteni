function deleteRow(id) {
    $.ajax({
        url: 'http://pojisteni.localhost.com/insurance-contracts/delete',
        data: { id },
        dataType: 'json',
        success: function (data) {
            $('#contractsTable tr[contract-id="' + id + '"]').remove();
            return true;
        }
    });
}