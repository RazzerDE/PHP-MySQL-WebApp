<?php
require_once 'assets/php/main.php';
require_once 'assets/php/utility.php';

$tableData = [];
$columnNames = null;
$tableName = null;

$current_table = "Wähle eine Tabelle in dem rechten Dropdown-Menü aus.";

// get table name
function getTableName(): string {
    if (isset($_GET['sql_statement'])) {
        preg_match('/FROM\s+(\w+)/i', str_replace("+", "", $_GET['sql_statement']), $matches);
        $tableName = $matches[1];
    } else if (isset($_GET['dropdownSelect'])) {
        $tableName = $_GET['dropdownSelect'];
    } else {
        $tableName = "buecher";
    }

    return $tableName;
}

// get all tables from database
function getTables(): array {
    global $conn;
    $SQL = "SHOW TABLES";
    $tables = [];

    $result = $conn->query($SQL);
    while($row = $result->fetch_array()){
        $tables[] = $row[0];
    }

    return $tables;
}


// get Table data
function getAllTableData($table = null, $statement = null): array {
    global $conn;
    global $tableData;
    global $tableName;

    if ($table == null) {
        $table = "buecher";
    }

    $tableName = $table;
    if ($statement != null) {
        $SQL = str_replace(";", "", $statement);
    } else {
        $SQL = 	"SELECT * FROM ". $table;
    }

    // sort table based on filter
    if (isset($_GET['filterBy'])) {
        // Diese SQL-Abfrage wäre nicht nur enorm schneller, sondern auch leichter - aber ihre Aufgabe will leider etwas anderes.
        $SQL .= " ORDER BY ".$_GET['filterBy']." ASC";

        // Dieser Code würde den "selectionSort"-Algorithmus verwenden, welcher sehr bekannt in PHP ist.
        // $tableData = selectionSort($tableData, $_GET['filterBy']);
    }

    $result = $conn->query($SQL);
    while($row = $result->fetch_assoc()){
        $tableData[] = $row;
    }

    return $tableData;
}

//          FUNCTIONS TO BUILD DESIGN OF PAGE

function buildTableHeaders(): void {
    global $tableData;
    global $columnNames;

    // Get column names from the first row of the result set
    $columnNames = array_keys($tableData[0]);

    // Start the table row
    echo '<tr>';

    // Loop through the column names and create a <th> element for each one
    foreach ($columnNames as $columnName) {
        echo '
            <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left text-gray-400">
                <button class="flex items-center gap-x-3 focus:outline-none cursor-default">
                    <span>' . htmlspecialchars($columnName) . '</span>
                    
                    <a id="ahref_'. $columnName . '">
                        <svg class="h-4 hover:text-white text-current cursor-pointer" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                            <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                            <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                        </svg>
                    </a>
                </button>
            </th>';
    }

    // EDIT & DELETE HEADER
    echo '
        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left text-gray-400">
            <span>Aktion</span>
        </th>';

    // End the table row
    echo '</tr>';
}

function buildTableRows(): void {
    global $tableData;
    global $columnNames;

    // create new row at start if user wants to add row
    echo newRowForm($tableData);

    // Loop through each row of data and create a <tr> element
    foreach ($tableData as $row) {
        echo '<tr>';
        // Loop through each column in the row and create a <td> element
        $columnContent = null;

        $count = 0;
        echo '<form name="editRow" method="post" id="editRowForm" onsubmit="this.form.submit();">';

        // add needed forms to row to allow edit/delete & save function
        foreach ($row as $cell) {
            $tdContent = '';

            if (strpos(getTableName(), '_has_') !== false or $count === 0) {
                $tdContent .= htmlspecialchars($cell);
                $columnContent = htmlspecialchars($cell);
            } else {
                $tdContent .= '<input id="editInp-' . $columnContent . '" disabled class="rounded w-full bg-gray-900" name="editRow[' . $columnNames[$count] . ']" value="' . $cell . '">';
                $tdContent .= '<input type="hidden" name="rowId" value="' . $columnNames[0] . ' = ' . $columnContent . '">';
            }

            echo '<td class="px-4 py-4 text-sm font-medium whitespace-nowrap">' . $tdContent . '</td>';
            $count += 1;
        }

        // show save button if user clicked on edit
        echo saveButton($columnContent);

        // show delete & edit buttons
        echo manageButtons($columnContent, $columnNames);

        echo '</div></td></tr>';
    }
}

// delete row from mysql database
function deleteRow($DELETE_PARAMETER): void {
    global $conn;
    global $tableName;

    // get table
    $tableName = getTableName();

    $SQL = "DELETE FROM " . $tableName . " WHERE $DELETE_PARAMETER ";
    $conn->query($SQL);

    header("Refresh: 0");
    exit();

}

// add row to mysql table
function insertNewRow(): void {
    global $conn;

    $tableName = getTableName();
    $fields = getFieldsForTable($tableName);

    $newRowValues = $_POST['newRow'];
    $columns = implode(", ", $fields);
    $placeholders = rtrim(str_repeat('?, ', count($newRowValues)), ', ');

    $newRowValues = str_replace(",",".", $newRowValues);

    // Prepare sql statement
    $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);

    $types = str_repeat('s', count($newRowValues)); // 's' mean string
    $stmt->bind_param($types, ...$newRowValues);

    executeStatement($stmt);
}

// edit row from mysql table
function updateRow(): void {
    global $conn;

    $tableName = getTableName();
    $fields = getFieldsForTable($tableName);

    $newRowValues = $_POST['editRow'];
    $id = $_POST['rowId'];
    $setStatement = '';

    // get values needed for update
    $intersect = array_intersect_key($newRowValues, array_flip($fields));
    foreach($intersect as $key => $value){
        $setStatement .= $key . " = '" . $value . "', ";
    }

    $setStatement = rtrim($setStatement, ', '); // remove the last comma
    $sql = "UPDATE $tableName SET ". $setStatement ." WHERE ". $id;
    $stmt = $conn->prepare($sql);

    executeStatement($stmt);
}