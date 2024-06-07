
//      FORM VERIFICATIONS

document.getElementById("SearchForm").addEventListener("submit", function(event) {
    let input = document.getElementById("sql_statement");

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
    const pattern = "SELECT\\s+(\\w+)\\s*((,\\s*\\w+\\s*)*)\\s+FROM\\s+\\w+\\s+WHERE\\s+\\w+\\s*(<|>|<>|<=|>=|=)\\s*[+-]?\\d+$";
    return pattern.test(sql);
}