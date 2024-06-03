<!DOCTYPE html>
<html lang="de">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP & MySQL - Task</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/favicon.ico" sizes="any">
  </head>

  <body class="overflow-hidden">

    <header class="bg-card">
      <div class="mx-auto max-w-screen-xl px-6 px-8">
        <div class="flex h-16 items-center justify-between">
          <img src="assets/img/logo.png" alt="Logo" width="40" height="40">

          <div class="flex items-center gap-12">
            <span>
              <a class="text-gray-500">Simple Webseite mit MySQL & PHP.</a>
            </span>

            <a class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow cursor-pointer
                      transition hover:bg-teal-600/80">Datenbank zurücksetzen</a>
          </div>
        </div>
      </div>
    </header>

    <section class="grid pt-10 pb-2 px-8 min-h-full w-full bg-full text-white w-full h-full px-4">
        <?php include 'assets/php/table.php' ?>
        <div class="sm:flex items-center justify-between">
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white">🧮 - <?php echo $current_table; ?></h2>
                </div>

                <div class="grid gap-4">

                </div>

                <p class="text-gray-300 text-sm">Diese kleine Webseite hat alle benötigten Features implementiert:</p>
                <div class="grid grid-cols-2 grid-rows-2 gap-8 gap-y-0 mb-0">
                    <p class="text-gray-300 text-sm">✔ - Alle Tabellen einsehen (über Rechtes Dropdown)</p>
                    <p class="text-gray-300 text-sm">✔ - SELECT-Statement selbst eingeben (über Suchleiste)</p>
                    <p class="text-gray-300 text-sm">✔ - Änderungen wie Bearbeiten/Hinzufügen (via Buttons)</p>
                    <p class="text-gray-300 text-sm">✔ - Optisch ansprechendes Design</p>
                </div>
            </div>

            <div class="flex items-center mt-4 gap-x-3">
                <button class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_3098_154395)">
                            <path d="M13.3333 13.3332L9.99997 9.9999M9.99997 9.9999L6.66663 13.3332M9.99997 9.9999V17.4999M16.9916 15.3249C17.8044 14.8818 18.4465 14.1806 18.8165 13.3321C19.1866 12.4835 19.2635 11.5359 19.0351 10.6388C18.8068 9.7417 18.2862 8.94616 17.5555 8.37778C16.8248 7.80939 15.9257 7.50052 15 7.4999H13.95C13.6977 6.52427 13.2276 5.61852 12.5749 4.85073C11.9222 4.08295 11.104 3.47311 10.1817 3.06708C9.25943 2.66104 8.25709 2.46937 7.25006 2.50647C6.24304 2.54358 5.25752 2.80849 4.36761 3.28129C3.47771 3.7541 2.70656 4.42249 2.11215 5.23622C1.51774 6.04996 1.11554 6.98785 0.935783 7.9794C0.756025 8.97095 0.803388 9.99035 1.07431 10.961C1.34523 11.9316 1.83267 12.8281 2.49997 13.5832" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_3098_154395">
                                <rect width="20" height="20" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>

                    <span>YANIC HIER DROPDOWN</span>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between pb-4">
            <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300">
                    Eintrag bearbeiten
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    Eintrag löschen
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    Eintrag erstellen
                </button>
            </div>

            <div class="relative flex items-center mt-0">
            <span class="absolute">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>

            <input type="text" placeholder="SQL-SELECT Statement.." class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
            </div>
        </div>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto -mx-8">
                <div class="inline-block min-w-full align-middle px-8">
                    <div class="overflow-hidden border border-gray-700 rounded-lg">
                        <table class="table-fixed border-separate min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-800">
                                <?php
                                    // Fetch table data
                                    $tableData = getAllTableData();

                                    // Check if we have data to display
                                    if (!empty($tableData)) {
                                        // Get column names from the first row of the result set
                                        $columnNames = array_keys($tableData[0]);

                                        // Start the table row
                                        echo '<tr>';

                                        // Loop through the column names and create a <th> element for each one
                                        foreach ($columnNames as $columnName) {
                                            echo '<th scope="col" class="py-3.5 px-4 text-sm font-normal text-left text-gray-400">';
                                            echo '<button class="flex items-center gap-x-3 focus:outline-none">';
                                            echo '<span>' . htmlspecialchars($columnName) . '</span>'; // Use htmlspecialchars to prevent XSS attacks
                                            echo '</button>';
                                            echo '</th>';
                                        }

                                        // End the table row
                                        echo '</tr>';
                                    } else {
                                        echo "<div class='flex justify-center align-center h-full'>Die Tabelle ist leer.</div>";
                                    }?>
                            </thead>
                            <tbody class="divide-y divide-gray-700 bg-gray-900 overflow-y-auto border border-collapse
                            border-spacing-y-0.5 border-gray-700 border rounded-b-lg" style="height: 52vh;">
                            <?php
                            // Loop through each row of data and create a <tr> element
                            foreach ($tableData as $row) {
                                echo '<tr>';
                                // Loop through each column in the row and create a <td> element
                                foreach ($row as $cell) {
                                    echo '<td class="px-4 py-4 text-sm font-medium whitespace-nowrap">';
                                    echo htmlspecialchars($cell); // Use htmlspecialchars to prevent XSS attacks
                                    echo '</td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <footer class="bg-full">
      <div class="container px-6 py-4 mx-auto" style="padding-top: 1px;">
        <hr class="my-4 border-gray-700" />

        <div class="flex items-center justify-center">
          <p class="text-sm text-gray-300">💕 - Erstellt von Yannic Drews & Yanic Döpner aus der EFI23a.</p>

        </div>
      </div>
    </footer>

    <script src="assets/js/app.js"></script>
  </body>
</html>
