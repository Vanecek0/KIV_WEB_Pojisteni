jQuery(function () {
    var limit = 10;
    var defaultLimit = limit;
    var offset = 0;
    var search = '';
    var orderby = 'id';
    var sort = 'ASC';

    function loadMoreRows() {
        $.ajax({
            url: '/users',
            data: { search, limit, offset, sort, orderby },
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    appendUserRows(data);
                    offset += limit;

                    if (data.length < limit) {
                        disableLoadMoreButton('Žádné další řádky');
                    } else {
                        enableLoadMoreButton('Načíst další');
                    }
                } else {
                    disableLoadMoreButton('Žádné další řádky');
                }
            }
        });
    }

    $("#loadMore").on("click", loadMoreRows);
    $('#searchInput').on('change', searchUsers);
    $('#sortButton').on('click', sortUsers);

    function searchUsers() {
        search = $('#searchInput').val();
        limit = defaultLimit;
        offset = 0;
        loadAllUsers();
    }

    function sortUsers() {
        orderby = $('#sortColumn').val();
        sort = $('#sortDirection').val();
        offset = 0;
        loadAllUsers();
    }

    function loadAllUsers() {
        $.ajax({
            url: '/users',
            data: { search, limit, offset, sort, orderby },
            dataType: 'json',
            success: function (data) {
                $('#clientsTable').empty();
                if (data.length > 0) {
                    appendUserRows(data);
                    offset = limit;
                    enableLoadMoreButton('Načíst další');
                } else {
                    disableLoadMoreButton('Žádné řádky k načtení');
                }
            }
        });
    }

    function appendUserRows(data) {
        data.forEach(item => {
            $('#clientsTable').append(`
        <tr user-id="${item.id}" class="table-row">
          <td>${item.id}</td>
          <td>${item.firstname}</td>
          <td>${item.lastname}</td>
          <td>${item.phone}</td>
          <td>${item.username}</td>
          <td>${item.email}</td>
          <td>${item.birth}</td>
          <td>${item.birth_number}</td>
          <td>${item.city}</td>
          <td>${item.street}</td>
          <td>${item.psc}</td>
          <td id="role">${item.role}</td>
          <td class='align-middle'>
            <div class='d-flex gap-2'>
              <a onclick="showEditModal(${item.id})" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-pencil-square"></i></a>
              <a onclick="if(confirm('Opravdu chcete odstranit tento záznam?')) {deleteRow(${item.id})}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
            </div>
          </td>
        </tr>
      `);
        });
    }

    function enableLoadMoreButton(text) {
        $('#loadMore').prop('disabled', false).text(text);
    }

    function disableLoadMoreButton(text) {
        $('#loadMore').prop('disabled', true).text(text);
    }

    loadAllUsers();
});