function getConstants() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/insurances-constants',
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
    const fetchInsuranceUrl = '/insurances/get';
    const $rowData = $('#rowData');

    function createInput(type, label, name, value, disabled = false) {
        return `
      ${label != '' ? `<label class="form-label" for="${name}">${label}</label>` : ``}
      <input type="${type}" class="form-control mb-3" name="${name}" value="${value}" ${disabled ? 'disabled' : ''}/>
    `;
    }

    function createTextArea(label, name, value) {
        return `
      ${label != '' ? `<label class="form-label" for="${name}">${label}</label>` : ``}
      <textarea class="form-control mb-3" name="${name}">${value}</textarea>
    `;
    }

    function createImageGallery(images) {
        let galleryHtml = '<div class="image-gallery"><div class="d-flex flex-wrap gap-2">';
    
        for (const image of images) {
            galleryHtml += `
                <img
                    src="./public/${image}"
                    class="img-fluid mb-4"
                    alt="{{ vehicle.brand }} {{ vehicle.model }}"
                />
            `;
        }
        galleryHtml += '</div></div>';
        return galleryHtml;
    }


    function createInsuranceConstantsOption(constants, selectedConstant) {
        return constants.map((value) => `
      <option value="${value}" ${selectedConstant === value ? 'selected' : ''}>${value}</option>
    `).join('');
    }

    $.ajax({
        url: fetchInsuranceUrl,
        data: { id },
        dataType: 'json',
        success: function (data) {
            $rowData.empty();
            if (data.length > 0) {
                const selectedReportState = $('#insurancesTable tr[insurance-id="' + id + '"] #report').text();
                getConstants().then(constants => {
                    const reportOptions = createInsuranceConstantsOption(constants.REPORT_STATE_OPTIONS, selectedReportState);

                    data.forEach(item => {
                        $rowData.append(`
            ${createInput('hidden', '', 'id', item.id)}
              ${createInput('text', 'Smlouva ID', 'contract_id', item.contract_id)}
              ${createInput('datetime-local', 'Datum nehody', 'accident_datetime', item.accident_datetime)}
              ${createInput('text', 'Místo nehody', 'accident_place', item.accident_place)}
              ${createTextArea('Popis', 'accident_description', item.accident_description)}
              ${createInput('text', 'Odhadovaná škoda', 'estimated_damage_amount', item.estimated_damage_amount)}
              ${createInput('text', 'Jméno viníka', 'culprit_firstname', item.culprit_firstname)}
              ${createInput('text', 'Příjmení viníka', 'culprit_lastname', item.culprit_lastname)}
              ${createInput('text', 'Telefon viníka', 'culprit_phone', item.culprit_phone)}
              ${createInput('text', 'Email viníka', 'culprit_email', item.culprit_email)}
              ${createInput('text', 'Město viníka', 'culprit_city', item.culprit_city)}
              ${createInput('text', 'Ulice viníka', 'culprit_street', item.culprit_street)}
              ${createInput('text', 'PSČ viníka', 'culprit_psc', item.culprit_psc)}
              ${createInput('text', 'SPZ viníka', 'culprit_spz', item.culprit_spz)}
              ${createInput('text', 'Vozidlo viníka', 'culprit_vehicle', item.culprit_vehicle)}
              ${createInput('text', 'Pojišťovna viníka', 'culprit_insurance', item.culprit_insurance)}
              <label class="form-label" for="report_state">Stav hlášení</label>
              <select class="form-control mb-3" name="report_state">${reportOptions}</select>
              ${createInput('datetime-local', 'Uzavřeno', 'closed_datetime', item.closed_datetime)}
              ${item.images ? createImageGallery(JSON.parse(item.images.replace(/\\/g, ''))) : ''}
            `);
                    });
                });

            }
        }
    });
}