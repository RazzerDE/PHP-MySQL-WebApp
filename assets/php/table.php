<?php
require_once 'assets/php/main.php';

$tableData = [];
$columnNames = null;
$tableName = null;
$current_table = $_GET['dropdownSelect'] ?? "Wähle eine Tabelle in dem rechten Dropdown-Menü aus.";

function executeSql($conn, $sql, $params) {
    // Bereiten Sie das SQL-Statement vor
    $stmt = $conn->prepare($sql);

    // Binden Sie die Parameter an das vorbereitete Statement
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    // Führen Sie das vorbereitete Statement aus
    if ($stmt->execute()) {
        echo "SQL statement executed successfully.";
    } else {
        echo "Error executing SQL statement: " . $stmt->error;
    }
}



// get Table data
function getAllTableData($table = null, $statement = null, $only_table = null): array {
    global $conn;
    global $tableData;

    if ($table == null) {
        $table = "buecher";
    }

    if ($only_table != null) {
        global $tableName;
        $tableName = $table;

        return [];
    }

    if ($statement != null) {
        $SQL = str_replace(";", "", $statement);
    } else {
        $SQL = 	"SELECT * FROM ". $table;
    }

    // sort table based on filter
    if (isset($_GET['filterBy'])) {
        // Diese SQL-Abfrage wäre nicht nur enorm schneller, sondern auch leichter - aber ihre Aufgabe will leider etwas anderes.
        $SQL .= " ORDER BY ".$_GET['filterBy']." ASC";

        // Dieser Code würde den "selectionSort"-Algorithmus verwenden, welcher sehr bekannt in PHP ist.
        // $tableData = selectionSort($tableData, $_GET['filterBy']);
    }

    $result = $conn->query($SQL);
    while($row = $result->fetch_assoc()){
        $tableData[] = $row;
    }

    return $tableData;
}

//          FUNCTIONS TO BUILD DESIGN OF PAGE

function buildTableHeaders(): void {
    global $tableData;
    global $columnNames;

    // Get column names from the first row of the result set
    $columnNames = array_keys($tableData[0]);

    // Start the table row
    echo '<tr>';

    // Loop through the column names and create a <th> element for each one
    foreach ($columnNames as $columnName) {
        echo '
            <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left text-gray-400">
                <button class="flex items-center gap-x-3 focus:outline-none cursor-default">
                    <span>' . htmlspecialchars($columnName) . '</span>
                    
                    <a id="ahref_'. $columnName . '">
                        <svg class="h-4 hover:text-white text-current cursor-pointer" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                            <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                            <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                        </svg>
                    </a>
                </button>
            </th>';
    }

    // EDIT & DELETE HEADER
    echo '
        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left text-gray-400">
            <span>Eintrag Edit</span>
        </th>';

    // End the table row
    echo '</tr>';
}

function buildTableRows(): void {
    global $tableData;
    $idCounter = 1; // Zähler für die eindeutige ID
    global $columnNames;

    // Neue Zeile mit Eingabefeldern
    echo '<form method="post"><tr id="newRow" style="display: none">';
    foreach ($tableData[0] as $cell) {
        echo '<td><input class="bg-gray-700" type="text" name="newRow[]"></td>';
    }
    echo '<td><input type="submit" value="&#128190"></td>';
    echo '</tr> </form';


    // Loop through each row of data and create a <tr> element
    foreach ($tableData as $row) {
        echo '<tr>';
        // Loop through each column in the row and create a <td> element
        $columnContent = null;

        $count = 0;
        foreach ($row as $cell) {
            if ($count === 0) {
                $columnContent = htmlspecialchars($cell);
            }
            echo '<td class="px-4 py-4 text-sm font-medium whitespace-nowrap">';
            echo htmlspecialchars($cell); // Use htmlspecialchars to prevent XSS attacks
            echo '</td>';

            $count += 1;
        }

        // EDIT & DELETE BUTTON
        echo '
            <td class="px-4 py-4 text-sm whitespace-nowrap">
                <div class="flex items-center gap-x-6">
                    <form method="post">
                        <button type="submit" name="deleteRow" value="' . $columnNames[0] . ' = '. $columnContent . '" class="text-gray-300 transition-colors duration-200 hover:text-red-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </form>

                    <button class="transition-colors duration-200 hover:text-yellow-500 text-gray-300 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </button>
                </div>
            </td>
        </tr>';
    }
}

// delete row from mysql database
function deleteRow($DELETE_PARAMETER): void {
    global $conn;
    global $tableName;
    echo $tableName;

    getAllTableData(null, null, true);
    $SQL = "DELETE FROM buchladen." . $tableName . " WHERE $DELETE_PARAMETER ";
    $conn->query($SQL);

    header("Refresh: 0");
    exit();

}
