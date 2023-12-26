function getConstants() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'http://pojisteni.localhost.com/contracts-constants',
            dataType: 'json',
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

function showEditModal(id) {
    const fetchContractUrl = 'http://pojisteni.localhost.com/insurance-contracts/get';
    const $rowData = $('#rowData');

    function createInput(type, label, name, value) {
        return `
      ${label != '' ? `<label class="form-label" for="${name}">${label}</label>` : ``}
      <input type="${type}" class="form-control mb-3" name="${name}" value="${value}" />
    `;
    }

    function createTextArea(label, name, value) {
        return `
      ${label != '' ? `<label class="form-label" for="${name}">${label}</label>` : ``}
      <textarea class="form-control mb-3" name="${name}">${value}</textarea>
    `;
    }


    function createContractConstantsOption(constants, selectedConstant) {
        return constants.map((value) => `
      <option value="${value}" ${selectedConstant === value ? 'selected' : ''}>${value}</option>
    `).join('');
    }

    $.ajax({
        url: fetchContractUrl,
        data: { id },
        dataType: 'json',
        success: function (data) {
            $rowData.empty();
            if (data.length > 0) {
                const selectedContractType = $('#contractsTable tr[contract-id="' + id + '"] #type').text();
                const selectedPaymentState = $('#contractsTable tr[contract-id="' + id + '"] #payment').text();
                getConstants().then(constants => {
                    const typesOptions = createContractConstantsOption(constants.TYPE_OPTIONS, selectedContractType);
                    const paymentOptions = createContractConstantsOption(constants.PAYMENT_STATE_OPTIONS, selectedPaymentState);

                    data.forEach(item => {
                        $rowData.append(`
            ${createInput('hidden', 'Id', 'id', item.id)}
              ${createInput('text', 'Klient', 'client_id', item.client_id)}
              ${createInput('text', 'Vozidlo', 'vehicle_id', item.vehicle_id)}
              <label class="form-label" for="type">Smlouva</label>
              <select class="form-control mb-3" name="type">${typesOptions}</select>
              ${createInput('number', 'Cena', 'price', item.price)}
              <label class="form-label" for="payment_state">Stav platby</label>
              <select class="form-control mb-3" name="payment_state">${paymentOptions}</select>
              ${createInput('date', 'Platné od', 'valid_from', item.valid_from)}
              ${createInput('date', 'Platné do', 'valid_to', item.valid_to)}
              ${createTextArea('Poznámka', 'notes', item.notes)}
            `);
                    });
                });

            }
        }
    });
}