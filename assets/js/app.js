
//      FORM VERIFICATIONS

document.getElementById("SearchForm").addEventListener("submit", function(event) {
    let input = document.getElementById("sql_statement");

    // verify sql statement
    if (!isValidSelectStatement(input.value)) {
        input.style.borderColor = "red";
        event.preventDefault();
    }
});

// make button visible for table reset if sql statement was used
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.size > 0) {
    document.getElementById("default_table").classList.remove("hidden");
}

// set correct href for every table header
let elements = document.querySelectorAll('[id^="ahref"]');
elements.forEach(element => {
    let currentUrl = new URL(window.location.href);
    let paramName = "filterBy";
    let paramValue = element.id.replace("ahref_", "");

    // Check if the parameter already exists
    if (currentUrl.searchParams.has(paramName)) {
        // If it exists, update its value
        currentUrl.searchParams.set(paramName, paramValue);
    } else {
        // If it doesn't exist, add it
        currentUrl.searchParams.append(paramName, paramValue);
    }

    // Update the href of the element
    element.href = currentUrl.toString();
});



//      FUNCTIONS

function isValidSelectStatement(sql) {
    const regex = /^SELECT\s[\w\*\)\(\,\s]+\sFROM\s[\w]+$/i;
    return regex.test(sql);
}

function editMode(id) {
    let input = document.querySelectorAll(`#editInp-`+id);
    let save = document.querySelectorAll(`#editSave-`+id);
    let edit = document.querySelectorAll(`#editButton-`+id);

    input.forEach((e) => {
        e.classList.add(`bg-gray-600`);
        e.disabled = false;
    });

    save.forEach((e) => {
        e.style.display = "";
    });

    edit.forEach((e) => {
        e.style.display = "none";
    })
}