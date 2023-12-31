function deleteRow(id) {
    $.ajax({
        url: 'http://pojisteni.localhost.com/users/delete',
        data: { id },
        dataType: 'json',
        success: function (data) {
            $('#clientsTable tr[user-id="' + id + '"]').remove();
            return true;
        }
    });
}