function getRoles() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/roles',
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
    const fetchUserUrl = '/users/get';
    const $rowData = $('#rowData');

    function createInput(type, label, name, value) {
        return `
      ${label != '' ? `<label class="form-label" for="${name}">${label}</label>` : ``}
      <input type="${type}" class="form-control mb-3" name="${name}" value="${value}" />
    `;
    }

    function createRoleOptions(roles, selectedRole) {
        return Object.keys(roles).map(key => `
      <option value="${roles[key]}" ${selectedRole === roles[key] ? 'selected' : ''}>${key}</option>
    `).join('');
    }

    function showModalWithUserData(id) {
        const fetchUserUrl = '/users/get';
        const $rowData = $('#rowData');

        return Object.keys(roles).map(key => `
      <option value="${roles[key]}" ${selectedRole === roles[key] ? 'selected' : ''}>${key}</option>
    `).join('');
    }

    $.ajax({
        url: fetchUserUrl,
        data: { id },
        dataType: 'json',
        success: function (data) {
            $rowData.empty();

            if (data.length > 0) {
                const selectedRole = $('#clientsTable tr[user-id="' + id + '"] #role').text();
                getRoles().then(roles => {
                    const rolesOptions = createRoleOptions(roles, selectedRole);

                    data.forEach(item => {
                        $rowData.append(`
            ${createInput('hidden', '', 'id', item.id)}
              ${createInput('text', 'Jméno', 'firstname', item.firstname)}
              ${createInput('text', 'Příjmení', 'lastname', item.lastname)}
              ${createInput('text', 'Telefon', 'phone', item.phone)}
              ${createInput('text', 'Uživatelské jméno', 'username', item.username)}
              ${createInput('text', 'Email', 'email', item.email)}
              ${createInput('date', 'Datum narození', 'birth', item.birth)}
              ${createInput('text', 'Rodné číslo', 'birth_number', item.birth_number)}
              ${createInput('text', 'Město', 'city', item.city)}
              ${createInput('text', 'Ulice', 'street', item.street)}
              ${createInput('text', 'PSČ', 'psc', item.psc)}
              <label class="form-label" for="role">Role</label>
              <select class="form-control mb-3" name="role">${rolesOptions}</select>
            `);
                    });
                });
            }
        }
    });
}