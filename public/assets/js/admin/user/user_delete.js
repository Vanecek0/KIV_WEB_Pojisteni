function deleteRow(id) {
    $.ajax({
        url: '/users/delete',
        data: { id },
        dataType: 'json',
        success: function (data) {
            $('#clientsTable tr[user-id="' + id + '"]').remove();
            return true;
        }
    });
}