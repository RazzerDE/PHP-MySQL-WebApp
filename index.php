<!DOCTYPE html>
<html lang="de">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP & MySQL - Task</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/favicon.ico" sizes="any">

    <!-- FIX Form resubmit -->
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
  </head>

  <body class="overflow-hidden">
    <?php include_once 'assets/php/buttons.php' ?>
    <header class="bg-card">
      <div class="mx-auto max-w-screen-xl px-6 px-8">
        <div class="flex h-16 items-center justify-between">
          <a href="index.php">
              <img src="assets/img/logo.png" alt="Logo" width="40" height="40">
          </a>

          <div class="flex items-center gap-12">
            <span>
              <a class="text-gray-500">Simple Webseite mit MySQL & PHP.</a>
            </span>

            <form id="ResetForm" method="post">
                <!-- RESET DB After Button click -->
                <input type="submit" name="reset_db" id="reset_db" value="Datenbank zurücksetzen"
                       class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow cursor-pointer
                      transition hover:bg-teal-600/80" />
            </form>
          </div>
        </div>
      </div>
    </header>

    <section class="grid pt-10 pb-2 px-8 min-h-full w-full bg-full text-white h-full px-4">
        <?php include_once 'assets/php/table.php'; getTableDataByURL(); ?>
        <div class="sm:flex items-center justify-between">
            <div>
                <div class="flex items-center gap-x-3">
                    <!-- Show currently used table -->
                    <h2 class="text-lg font-medium text-white">🧮 - <?php global $current_table; echo $current_table; ?></h2>
                </div>

                <p class="text-gray-300 text-sm">Diese kleine Webseite hat alle benötigten Features implementiert:</p>
                <div class="grid grid-cols-2 grid-rows-2 gap-0 gap-y-0 mb-0">
                    <p class="text-gray-300 text-sm">✔ - Alle Tabellen einsehen (über Rechtes Dropdown)</p>
                    <p class="text-gray-300 text-sm">✔ - SELECT-Statement selbst eingeben (über Suchleiste)</p>
                    <p class="text-gray-300 text-sm">✔ - Änderungen wie Bearbeiten/Hinzufügen (via Buttons)</p>
                    <p class="text-gray-300 text-sm">✔ - Filtern nach Spalte mit Selectionsort (Icon neben dem Spaltennamen)</p>
                </div>
            </div>

            <div class="flex items-center mt-4 gap-x-3">
                <form id="dropdownForm" action="" method="get">
                    <label for="dropdownSelect">
                        <select id="dropdownSelect" name="dropdownSelect" onchange="this.form.submit()" class="flex items-center text-white justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 bg-gray-900 hover:bg-gray-100 border-gray-700">
                            <option disabled selected hidden="hidden" value=""><?php echo getTableName(); ?></option>

                            <?php
                            // get tables for dropdown
                            $tables = getTables();
                            foreach ($tables as $table) {
                                echo "<option value='$table'>$table</option>";
                            } ?>
                        </select>
                    </label>
                </form>
            </div>
        </div>

        <div class="flex items-center justify-between pb-4">
            <div class="inline-flex overflow-hidden border divide-x rounded-lg bg-gray-900 border-gray-700 divide-gray-700">
                <button onclick="document.getElementById('newRow').style.display = '';" class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    Neuen Eintrag erstellen
                </button>
            </div>

            <!-- RESET Table Button if custom SQL Statement was used -->
            <a href="index.php" class="hidden" id="default_table">
                <input type="submit" name="reset_table" id="reset_table" value="Standard-Tabelle anzeigen"
                       class="rounded-md bg-rose-600 px-5 py-2.5 text-sm font-medium text-white shadow cursor-pointer
                                      transition hover:bg-rose-600/80" />
            </a>

            <div class="relative flex items-center mt-0">
                <span class="absolute ml-3.5 mt-0.5">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.48 4.54C17.1332 3.44415 14.5886 2.83523 12 2.75C9.41134 2.83523 6.8668 3.44415 4.51999 4.54C4.21866 4.68158 3.96427 4.90664 3.78702 5.18847C3.60977 5.47031 3.51709 5.79708 3.51999 6.13V17.87C3.51709 18.2029 3.60977 18.5297 3.78702 18.8115C3.96427 19.0934 4.21866 19.3184 4.51999 19.46C6.8668 20.5559 9.41134 21.1648 12 21.25C14.5886 21.1648 17.1332 20.5559 19.48 19.46C19.7813 19.3184 20.0357 19.0934 20.213 18.8115C20.3902 18.5297 20.4829 18.2029 20.48 17.87V6.13C20.4829 5.79708 20.3902 5.47031 20.213 5.18847C20.0357 4.90664 19.7813 4.68158 19.48 4.54ZM19 12.54C16.8088 13.5858 14.4264 14.1712 12 14.26C9.57362 14.1712 7.19122 13.5858 4.99999 12.54V8.68C7.20966 9.65164 9.58702 10.1848 12 10.25C14.413 10.1848 16.7903 9.65164 19 8.68V12.54ZM5.14999 5.9C7.2984 4.89285 9.62863 4.33155 12 4.25C14.3743 4.33323 16.7075 4.89442 18.86 5.9C18.9021 5.92191 18.9374 5.95492 18.9621 5.99547C18.9868 6.03601 18.9999 6.08254 19 6.13V7C16.8088 8.0458 14.4264 8.63119 12 8.72C9.57362 8.63119 7.19122 8.0458 4.99999 7V6.1C5.00524 6.05643 5.02187 6.01501 5.0482 5.9799C5.07453 5.9448 5.10964 5.91724 5.14999 5.9ZM18.85 18.1C16.7016 19.1071 14.3714 19.6684 12 19.75C9.62566 19.6668 7.29248 19.1056 5.13999 18.1C5.09789 18.0781 5.06258 18.0451 5.0379 18.0045C5.01322 17.964 5.00011 17.9175 4.99999 17.87V14.18C7.20966 15.1516 9.58702 15.6848 12 15.75C14.413 15.6848 16.7903 15.1516 19 14.18V17.87C19.0002 17.9188 18.9861 17.9666 18.9594 18.0074C18.9327 18.0483 18.8947 18.0805 18.85 18.1Z" fill="#495361"/>
                        </svg>
                </span>

                <form id="SearchForm" method="get">
                    <label><input type="text" name="sql_statement" id="sql_statement"
                                  placeholder="SELECT spalte FROM tabelle"
                                  class="block py-1.5 pr-5 border rounded-lg w-96 placeholder-gray-400/70 pl-11
                                  bg-gray-900 text-gray-300 border-gray-600 focus:border-blue-300 focus:ring-blue-300
                                  focus:outline-none focus:ring focus:ring-opacity-40">
                    </label>
                </form>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto -mx-8">
                <div class="inline-block min-w-full align-middle px-8">
                    <div class="overflow-auto border border-gray-700 rounded-lg" style="max-height: 55vh;">
                        <table class="table-fixed border-separate min-w-full divide-y divide-gray-700" id="mysql-table">
                            <thead class="bg-gray-800 sticky top-0">
                                <?php

                                    // Check if we have data to display
                                    if (!empty($tableData)) {
                                        // build the needed table headers by columns
                                        buildTableHeaders();
                                    } else {
                                        echo "<div class='flex justify-center align-center h-full'>Die Tabelle ist leer.</div>";
                                    }?>
                            </thead>
                            <tbody class="divide-y divide-gray-700 bg-gray-900 overflow-y-auto border border-collapse
                            border-spacing-y-0.5 border-gray-700 border rounded-b-lg">
                                <?php buildTableRows(); // build a table row for every row inside the DB table ?>
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
  </body>
  <script src="assets/js/app.js"></script>
</html>
