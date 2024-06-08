<?php
require_once 'assets/php/table.php';

//      FUNCTIONS RELATED TO BUTTON CLICKS

// reset DB after button click
if (!empty($_POST['reset_db'])) {
    resetDB(true);
}

// delete row from table
if (!empty($_POST['deleteRow'])) {
    deleteRow($_POST['deleteRow']);
}

if (!empty($_POST['newRow'])) {
    global $conn;

    $newRowValues = $_POST['newRow'];
    $tableName = getTableName();
    $fields = getFields($tableName);

    $columns = implode(", ", $fields);
    $placeholders = rtrim(str_repeat('?, ', count($newRowValues)), ', ');

    $newRowValues = str_replace(",",".", $newRowValues);

    // Prepare sql statement
    $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

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
        if (!checkDatesInArray($newRowValues)) {
            echo "<p class='text-center bg-red-700 border rounded border-gray-700'>". "Datum wurde nicht Regelkonform eingegeben YYYY-MM-DD". "</p>";
        } else {
            echo "<p class='text-center bg-red-700 border rounded border-gray-700'>" . "Fehler beim Ausführen des SQL-Statements: " . $e->getMessage() . "</p>";
        }
    }

}

// used to get fields for all table cells
function getFields($tableName): array {
    $tableFields = [
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

    return isset($tableFields[$tableName]) ? $tableFields[$tableName] : [];
}