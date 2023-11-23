function inputSet(inputName = null) {
    var allSets = document.querySelectorAll('.inputSet');

    allSets.forEach(function (set) {
        var setInputs = set.querySelectorAll('.inputField');
        var selectedRadio = set.querySelector('.setSelection:checked');

        setInputs.forEach(function (input) {
            var label = document.querySelector('label[for=' + input.id + ']');

            if (selectedRadio && input.classList.contains(inputName)) {
                input.style.display = 'inline-block';
                label.style.display = 'inline-block';
                input.removeAttribute('disabled');
            } else {
                input.style.display = 'none';
                label.style.display = 'none';
                input.setAttribute('disabled', 'true');
            }
        });
    });
}

window.onload = function () {
    var onClickAttribute = document.querySelector('.setSelection:checked').getAttribute('onclick');
    var match = onClickAttribute.match(/\('([^']+)'\)/);

    if (!(match && match[1])) {
        return inputSet();
    }

    var setIdentifier = match[1];
    return inputSet(setIdentifier);
}

//document.onload(inputSet())