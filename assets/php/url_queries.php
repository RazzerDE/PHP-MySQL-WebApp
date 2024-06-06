<?php

#       MODIFY TABLE BASED ON URL_QUERIES

function getTableDataByURL(): void {
    global $conn;
    global $tableData;

    // change sql statement if another one is needed
    if (isset($_GET['sql_statement'])) {
        getAllTableData(null, $_GET['sql_statement']);
    } else if (isset($_GET['dropdownSelect'])) {
        $table = $_GET['dropdownSelect'];
        getAllTableData(null, 'SELECT * FROM '.$table);
    } else {
        getAllTableData();
    }

    $selectedTable = $_GET['dropdownSelect'] ?? 'buecher';

    $fields = [];
    switch ($selectedTable) {
        case 'autoren':
            $fields = ['autoren_id', 'vorname', 'nachname', 'geburtsdatum'];
            break;
        case 'autoren_has_buecher':
            $fields = ['autoren_autoren_id', 'buecher_buecher_id'];
            break;
        case 'buecher':
            $fields = ['buecher_id', 'titel', 'verkaufspreis', 'einkaufspreis', 'erscheinungsjahr', 'verlage_verlage_id'];
            break;
        case 'buecher_has_lieferanten':
            $fields = ['buecher_buecher_id', 'lieferanten_lieferanten_id'];
            break;
        case 'buecher_has_sparten':
            $fields = ['buecher_buecher_id', 'sparten_sparten_id'];
            break;
        case 'lieferanten':
            $fields = ['lieferanten_id', 'name', 'orte_orte_id'];
            break;
        case 'orte':
            $fields = ['orte_id', 'postleitzahl', 'name'];
            break;
        case 'sparten':
            $fields = ['sparten_id', 'bezeichnung'];
            break;
        case 'verlage':
            $fields = ['verlage_id', 'name', 'orte_orte_id'];
            break;
    }


    if (isset($_POST['newRow'])) {
        $newRowValues = $_POST['newRow'];

        $columns = implode(", ", $fields);
        $placeholders = rtrim(str_repeat('?, ', count($newRowValues)), ', ');

        // Prepare sql statement
        $sql = "INSERT INTO $selectedTable ($columns) VALUES ($placeholders)";

        $stmt = $conn->prepare($sql);

        $types = str_repeat('s', count($newRowValues)); // 's' mean string
        $stmt->bind_param($types, ...$newRowValues);

        try {
            // Versuchen Sie, das Statement auszuführen
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            // Fangen Sie den Fehler ab und behandeln Sie ihn
            echo "Fehler beim Ausführen des SQL-Statements: " . $e->getMessage();
        }

    }



    // reset database if empty
    if (empty($tableData)) {
        resetDB();
    }

}