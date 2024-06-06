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


    if (isset($_GET['newRow'])) {
        $newRowValues = $_GET['newRow'];

        // Erstellen Sie die Teile des SQL-Statements
        $columns = implode(", ", $fields);
        $placeholders = rtrim(str_repeat('?, ', count($newRowValues)), ', ');

        // Erstellen Sie das SQL-Statement
        $sql = "INSERT INTO $selectedTable ($columns) VALUES ($placeholders)";

        // Bereiten Sie das SQL-Statement vor
        $stmt = $conn->prepare($sql);

        // Binden Sie die Parameter an das vorbereitete Statement
        $types = str_repeat('s', count($newRowValues)); // 's' bedeutet, dass der Parameter ein String ist
        $stmt->bind_param($types, ...$newRowValues);

        // Führen Sie das vorbereitete Statement aus
        if ($stmt->execute()) {

        } else {
            echo "Error executing SQL statement: " . $stmt->error;
        }
    }



    // reset database if empty
    if (empty($tableData)) {
        resetDB();
    }

}