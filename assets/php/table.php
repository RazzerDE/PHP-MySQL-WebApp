<?php

$servername = "localhost";
$username = "root";
# TODO: CHANGE PASSWORD FOR XAMP!
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Run sql init
//resetDB();

getAllTableData();


$current_table = "Wähle eine Tabelle in dem rechten Dropdown-Menü aus.";


// get Table data
function getAllTableData() {
    global $conn;

    $SQL = 	"SELECT * FROM buchladen.autoren;";
    $tableData = [];

    $result = $conn->query($SQL);

    while($row = $result->fetch_assoc()){
        $tableData[] = $row;
    }

    return $tableData;
}

//Function to rebuild the database
function resetDB() {
    global $conn;

    $filename = 'assets/sql/buchladen.sql';

    $tempLine = '';
    // Read in the full file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line) {

        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        // Add this line to the current segment
        $tempLine .= $line;
        // If its semicolon at the end, so that is the end of one query
        if (substr(trim($line), -1, 1) == ';') {
            // Perform the query
            mysqli_query($conn, $tempLine) or print("Error in " . $tempLine . ":" . mysqli_error());
            // Reset temp variable to empty
            $tempLine = '';
        }
    }

}
