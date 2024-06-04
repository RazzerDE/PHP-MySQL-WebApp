<?php

#       MODIFY TABLE BASED ON URL_QUERIES

function getTableDataByURL(): void {
    global $tableData;

    // change sql statement if another one is needed
    if (isset($_GET['sql_statement'])) {
        getAllTableData(null, $_GET['sql_statement']);
    } else if (isset($_GET['dropdownSelect'])) {
        $table = $_GET['dropdownSelect'];
        getAllTableData(null, 'SELECT+*+FROM+'.$table);
    } else {
        getAllTableData();
    }

    // reset database if empty
    if (empty($tableData)) {
        resetDB();
    }

}