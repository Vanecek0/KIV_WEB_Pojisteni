var currentTab = 0;
showTab(currentTab);

function showTab(n) {
    var x = document.getElementsByClassName("step");
    x[n].style.display = "block";

    if (n == 0) {
        document.getElementById("prevBtn").disabled = true;
    } else {
        document.getElementById("prevBtn").disabled = false;
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "inline";
    } else {
        document.getElementById("nextBtn").innerHTML = "Pokračovat";
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("submitBtn").style.display = "none";
    }
    fixStepIndicator(n)
}

function nextPrev(n) {
    var x = document.getElementsByClassName("step");
    if (n == 1 && !validateForm()) return false;
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
        return false;
    } else {
        showTab(currentTab);
    }
}

function validateForm() {

    var x, y, i, valid = true;
    x = document.getElementsByClassName("step");
    y = x[currentTab].getElementsByTagName("input");

    for (i = 0; i < y.length; i++) {
        if (y[i].value == "" && y[i].hasAttribute('required')) {
            var classArr = y[i].className.split(' ');
            if (classArr.indexOf("border-danger") === -1) {
                classArr.push("border-danger");
                y[i].className = classArr.join(" ");
                var errorEl = document.getElementById("errorMessage");
                errorEl.textContent = "Vyplňte prosím všechna povinná pole označená (*)";
            }
            valid = false;
        }
        else {
            var classArr = y[i].className.split(' ');
            if (classArr.indexOf("border-danger") !== -1) {
                classArr.pop("border-danger");
                y[i].className = classArr.join(" ");
                var errorEl = document.getElementById("errorMessage");
                errorEl.textContent = "";
            }
        }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
    }
    return valid; // return the valid status
}

function fixStepIndicator(n) {
    var i, x = document.getElementsByClassName("stepIndicator");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    x[n].className += " active";
}