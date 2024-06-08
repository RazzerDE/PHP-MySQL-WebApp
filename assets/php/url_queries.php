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

//    if (isset($_POST['editRow'])) {
//        $newRowValues = explode(',', $_POST['inputValues']);
//        $id = $_POST['editRow'];
//
//        $fields = implode(", ", $fields);
//
//        $newString = strstr($fields, ',');
//        $fields = explode(',', ltrim($newString, ', '));
//
//        $setStatement = "";
//        for ($i = 0; $i < count($fields); $i++) {
//            // Trim the values and add quotes around them if they are strings
//            $value = trim($newRowValues[$i]);
//            if (!is_numeric($value)) {
//                $value = "'" . $conn->real_escape_string($value) . "'";
//            }
//            $setStatement .= trim($fields[$i]) . " = " . $value;
//            if ($i != count($fields) - 1) {
//                $setStatement .= ", ";
//            }
//        }
//
//        // Prepare sql statement
//        $sql = "UPDATE $selectedTable SET ". $setStatement ." WHERE ". $id;
//
//        $stmt = $conn->prepare($sql);
//
//        try {
//            // Versuchen Sie, das Statement auszuführen
//            $stmt->execute();
//            header("Refresh:0");
//            exit();
//        } catch (mysqli_sql_exception $e) {
//            // Fangen Sie den Fehler ab und behandeln Sie ihn
//            if (!checkDatesInArray($newRowValues)) {
//                echo "<p class='text-center bg-red-700 border rounded border-gray-700'>". "Datum wurde nicht Regelkonform eingegeben YYYY-MM-DD". "</p>";
//            } else {
//                echo "<p class='text-center bg-red-700 border rounded border-gray-700'>" . "Fehler beim Ausführen des SQL-Statements: " . $e->getMessage() . "</p>";
//            }
//        }
//    }


    // reset database if empty
    if (empty($tableData)) {
        resetDB();
    }
}