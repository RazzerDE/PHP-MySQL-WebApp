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
