<?php

#       MODIFY TABLE BASED ON URL_QUERIES

function getTableDataByURL() {
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

    // reset database if empty
    if (empty($tableData)) {
        resetDB();
    }
}

function getFieldsForTable($selectedTable): array {
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
