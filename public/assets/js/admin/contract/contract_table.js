jQuery(function () {
    var limit = 10;
    var defaultLimit = limit;
    var offset = 0;
    var search = '';
    var orderby = 'id';
    var sort = 'ASC';

    function loadMoreRows() {
        $.ajax({
            url: '/insurance-contracts',
            data: { search, limit, offset, sort, orderby },
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    appendContractRows(data);
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
    $('#searchInput').on('change', searchContracts);
    $('#sortButton').on('click', sortUsers);

    function searchContracts() {
        search = $('#searchInput').val();
        limit = defaultLimit;
        offset = 0;
        loadAllContracts();
    }

    function sortUsers() {
        orderby = $('#sortColumn').val();
        sort = $('#sortDirection').val();
        offset = 0;
        loadAllContracts();
    }

    function loadAllContracts() {
        $.ajax({
            url: '/insurance-contracts',
            data: { search, limit, offset, sort, orderby },
            dataType: 'json',
            success: function (data) {
                $('#contractsTable').empty();
                if (data.length > 0) {
                    appendContractRows(data);
                    offset = limit;
                    enableLoadMoreButton('Načíst další');
                } else {
                    disableLoadMoreButton('Žádné řádky k načtení');
                }
            }
        });
    }

    function appendContractRows(data) {
        data.forEach(item => {
            $('#contractsTable').append(`
        <tr contract-id="${item.id}" class="table-row">
          <td>${item.id}</td>
          <td>${item.client_id}</td>
          <td>${item.vehicle_id}</td>
          <td id="type">${item.type}</td>
          <td>${item.price}</td>
          <td id="payment">${item.payment_state}</td>
          <td>${item.valid_from}</td>
          <td>${item.valid_to}</td>
          <td>${item.notes}</td>
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

    loadAllContracts();
});