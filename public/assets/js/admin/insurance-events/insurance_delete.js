function deleteRow(id) {
    $.ajax({
        url: '/insurances/delete',
        data: { id },
        dataType: 'json',
        success: function (data) {
            $('#insurancesTable tr[insurance-id="' + id + '"]').remove();
            return true;
        }
    });
}