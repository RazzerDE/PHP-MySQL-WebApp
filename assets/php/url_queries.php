<?php

#       MODIFY TABLE BASED ON URL_QUERIES

function getTableDataByURL() {
    global $conn;
    global $tableData;

    $selectedTable = 'buecher';
    $sql = 'SELECT * FROM '.$selectedTable;

    if (isset($_GET['sql_statement'])) {
        $sql = $_GET['sql_statement'];
        preg_match('/FROM\s+(\w+)/i', $sql, $matches);
        $selectedTable = $matches[1];
    } else if (isset($_GET['dropdownSelect'])) {
        $selectedTable = $_GET['dropdownSelect'];
        $sql = 'SELECT * FROM '.$selectedTable;
    }

    getAllTableData(null, $sql);

    $fields = getFieldsForTable($selectedTable);

    if (isset($_POST['newRow'])) {
        insertNewRow($selectedTable, $fields);
    }

    if (isset($_POST['editRow'])) {
        updateRow($selectedTable, $fields);
    }

    // reset database if empty
    if (empty($tableData)) {
        resetDB();
    }
}

function getFieldsForTable($selectedTable) {
    $fields = [];
    $tables = [
        'autoren' => ['autoren_id', 'vorname', 'nachname', 'geburtsdatum'],
        'autoren_has_buecher' => ['autoren_autoren_id', 'buecher_buecher_id'],
        'buecher' => ['buecher_id', 'titel', 'verkaufspreis', 'einkaufspreis', 'erscheinungsjahr', 'verlage_verlage_id'],
        'buecher_has_lieferanten' => ['buecher_buecher_id', 'lieferanten_lieferanten_id'],
        'buecher_has_sparten' => ['buecher_buecher_id', 'sparten_sparten_id'],
        'lieferanten' => ['lieferanten_id', 'name', 'orte_orte_id'],
        'orte' => ['orte_id', 'postleitzahl', 'name'],
        'sparten' => ['sparten_id', 'bezeichnung'],
        'verlage' => ['verlage_id', 'name', 'orte_orte_id']
    ];
    if (array_key_exists($selectedTable, $tables)) {
        $fields = $tables[$selectedTable];
    }
    return $fields;
}

function insertNewRow($selectedTable, $fields) {
    global $conn;

    $newRowValues = $_POST['newRow'];
    $columns = implode(", ", $fields);
    $placeholders = rtrim(str_repeat('?, ', count($newRowValues)), ', ');

    $newRowValues = str_replace(",",".", $newRowValues);

    // Prepare sql statement
    $sql = "INSERT INTO $selectedTable ($columns) VALUES ($placeholders)";

    $stmt = $conn->prepare($sql);

    $types = str_repeat('s', count($newRowValues)); // 's' mean string
    $stmt->bind_param($types, ...$newRowValues);

    try {
        // Versuchen Sie, das Statement auszuführen
        $stmt->execute();
        header("Refresh:0");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Fangen Sie den Fehler ab und behandeln Sie ihn
        handleSqlException($e, $newRowValues);
    }
}

function updateRow($selectedTable, $fields) {
    global $conn;

    $newRowValues = explode(',', $_POST['inputValues']);
    $id = $_POST['editRow'];

    $setStatement = "";
    for ($i = 0; $i < count($fields); $i++) {
        // Trim the values and add quotes around them if they are strings
        $value = trim($newRowValues[$i]);
        if (!is_numeric($value)) {
            $value = "'" . $conn->real_escape_string($value) . "'";
        }
        $setStatement .= trim($fields[$i]) . " = " . $value;
        if ($i != count($fields) - 1) {
            $setStatement .= ", ";
        }
    }

    // Prepare sql statement
    $sql = "UPDATE $selectedTable SET ". $setStatement ." WHERE ". $id;

    $stmt = $conn->prepare($sql);

    try {
        // Versuchen Sie, das Statement auszuführen
        $stmt->execute();
        header("Refresh:0");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Fangen Sie den Fehler ab und behandeln Sie ihn
        handleSqlException($e, $newRowValues);
    }
}

function handleSqlException($e, $newRowValues) {
    if (!checkDatesInArray($newRowValues)) {
        echo "<p class='text-center bg-red-700 border rounded border-gray-700'>". "Datum wurde nicht Regelkonform eingegeben YYYY-MM-DD". "</p>";
    } else {
        echo "<p class='text-center bg-red-700 border rounded border-gray-700'>" . "Fehler beim Ausführen des SQL-Statements: " . $e->getMessage() . "</p>";
    }
}

function checkDatesInArray($array) {
    foreach ($array as $item) {
        // Überprüfen, ob das Element ein Datum im Format 'YYYY-MM-DD' ist
        if (preg_match("/\d{4}-\d{2}-\d{2}/", $item)) {
            // Zerlegen des Datums in Jahr, Monat und Tag
            list($year, $month, $day) = explode("-", $item);

            // Überprüfen, ob das Datum gültig ist
            if (!checkdate((int)$month, (int)$day, (int)$year)) {
                return false;
            }
        }
    }
    return true;
}
