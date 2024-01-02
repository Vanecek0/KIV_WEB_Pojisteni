jQuery(function () {
    var limit = 10;
    var defaultLimit = limit;
    var offset = 0;
    var search = '';
    var orderby = 'id';
    var sort = 'ASC';

    function loadMoreRows() {
        $.ajax({
            url: 'http://pojisteni.localhost.com/insurances',
            data: { search, limit, offset, sort, orderby },
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    appendInsuranceRows(data);
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
    $('#searchInput').on('change', searchInsurances);
    $('#sortButton').on('click', sortUsers);

    function searchInsurances() {
        search = $('#searchInput').val();
        limit = defaultLimit;
        offset = 0;
        loadAllInsurances();
    }

    function sortUsers() {
        orderby = $('#sortColumn').val();
        sort = $('#sortDirection').val();
        offset = 0;
        loadAllInsurances();
    }

    function loadAllInsurances() {
        $.ajax({
            url: 'http://pojisteni.localhost.com/insurances',
            data: { search, limit, offset, sort, orderby },
            dataType: 'json',
            success: function (data) {
                $('#insurancesTable').empty();
                if (data.length > 0) {
                    appendInsuranceRows(data);
                    offset = limit;
                    enableLoadMoreButton('Načíst další');
                } else {
                    disableLoadMoreButton('Žádné řádky k načtení');
                }
            }
        });
    }

    function appendInsuranceRows(data) {
        data.forEach(item => {
            $('#insurancesTable').append(`
        <tr insurance-id="${item.id}" class="table-row">
          <td>${item.id}</td>
          <td>${item.contract_id}</td>
          <td>${item.accident_datetime}</td>
          <td>${item.accident_place}</td>
          <td>${item.accident_description}</td>
          <td>${item.estimated_damage_amount}</td>
          <td>${item.culprit_firstname}</td>
          <td>${item.culprit_lastname}</td>
          <td>${item.culprit_phone}</td>
          <td>${item.culprit_email}</td>
          <td>${item.culprit_city}</td>
          <td>${item.culprit_street}</td>
          <td>${item.culprit_psc}</td>
          <td>${item.culprit_spz}</td>
          <td>${item.culprit_vehicle}</td>
          <td>${item.culprit_insurance}</td>
          <td id="report">${item.report_state}</td>
          <td>${item.closed_datetime}</td>
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

    loadAllInsurances();
});