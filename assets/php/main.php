<?php
$servername = "localhost";
$database = "buchladen";
$username = "root";
# TODO: CHANGE PASSWORD FOR XAMP!
$password = "";

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $database);
    # TODO: DER "SELECTIONSORT"-ALGORITHMUS IST IN DER TABLE.PHP DATEI ZU FINDEN.

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $ex) {
    if (strpos($ex->getMessage(), 'Unknown database') !== false) {
        echo 'Die Datenbank "buchladen" existiert nicht. Bitte führe das SQL-Script aus, damit diese Seite funktioniert.';
    } else {
        echo 'Die Anmeldedaten für die Datenbank sind nicht korrekt - bitte korrigiere diese, damit diese Seite funktioneirt.';
    }

    exit();
}

function resetDB($redirected = False): void {
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
        if (substr(trim($line), -1, 1) == ';')  {
            // Perform the query
            mysqli_query($conn, $tempLine) or print("Error in " . $tempLine .":". mysqli_error($conn));
            // Reset temp variable to empty
            $tempLine = '';
        }
    }

    if ($redirected) {
        header('Location: index.php', true, 303);
        exit();
    }

}

function selectionSort($tableData, $attribute): array {
    $n = count($tableData);
    for ($i = 0; $i < $n; $i++) {
        $minIndex = $i;
        for ($j = $i + 1; $j < $n; $j++) {
            if ($tableData[$j][$attribute] < $tableData[$minIndex][$attribute]) {
                $minIndex = $j;
            }
        }

        $temp = $tableData[$i];
        $tableData[$i] = $tableData[$minIndex];
        $tableData[$minIndex] = $temp;
    }

    return $tableData;
}

function executeStatement($stmt): void {
    try {
        $stmt->execute();
        header("Refresh:0");
        exit();
    } catch (mysqli_sql_exception $e) {
        handleSqlException($e);
    }
}

function handleSqlException($e): void {
    echo "<p class='text-center bg-red-700 border rounded border-gray-700'>" . "Fehler beim Ausführen des SQL-Statements: " . $e->getMessage() . "</p>";
}

include_once 'assets/php/url_queries.php';
