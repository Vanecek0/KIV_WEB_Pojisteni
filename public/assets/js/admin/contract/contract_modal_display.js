function showEditModal(id) {
    const fetchContractUrl = 'http://pojisteni.localhost.com/contracts/get';
    const $rowData = $('#rowData');

    function createInput(type, label, name, value) {
        return `
      ${label != '' ? `<label class="form-label" for="${name}">${label}</label>` : ``}
      <input type="${type}" class="form-control mb-3" name="${name}" value="${value}" />
    `;
    }

    $.ajax({
        url: fetchContractUrl,
        data: { id },
        dataType: 'json',
        success: function (data) {
            $rowData.empty();
            if (data.length > 0) {
                data.forEach(item => {
                    $rowData.append(`
            ${createInput('hidden', 'id', 'id', item.id)}
              ${createInput('text', 'Klient', 'client_id', item.client_id)}
              ${createInput('text', 'Vozidlo', 'vehicle_id', item.vehicle_id)}
              ${createInput('text', 'Smlouva', 'type', item.type)}
              ${createInput('text', 'Cena', 'price', item.price)}
              ${createInput('text', 'Stav platby', 'payment_state', item.payment_state)}
              ${createInput('date', 'Platné od', 'valid_from', item.valid_from)}
              ${createInput('date', 'Platné do', 'valid_to', item.valid_to)}
              ${createInput('text', 'Poznámka', 'notes', item.notes)}
            `);
                });

            }
        }
    });
}