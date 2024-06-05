<h1 align="center">
     🖥 PHP-MySQL-WebApp ~ Learn to work with Databases
</h1>

<p align="center">
  <i align="center">This project involves a user-friendly website to display tables from a MySQL database - developed using HTML/CSS and JavaScript with PHP.</i>

  ![image](https://github.com/RazzerDE/PHP-MySQL-WebApp/assets/49283907/192d06e0-7c20-4b35-9a04-eb74d6a0df78)

</p>

<h4 align="center">
  <a href="https://www.php.net/releases/8.3/en.php">
    <img src="https://img.shields.io/badge/version-PHP_8.3-27ae60?style=for-the-badge" alt="php version" style="height: 25px;">
  </a>
  <a href="https://www.php.net/releases/8.3/en.php">
    <img src="https://img.shields.io/badge/database-MySQL_8.0-2980b9?style=for-the-badge" alt="php version" style="height: 25px;">
  </a>
  <a href="https://discord.gg/bl4cklist">
    <img src="https://img.shields.io/discord/616655040614236160?style=for-the-badge&logo=discord&label=Discord&color=%237289da" alt="discord server" style="height: 25px;">
  </a>
  <br>
</h4>

## 🗯️ Introduction
› This project is centered around the development of a user-friendly website. The website was crafted using HTML, CSS, JavaScript, and PHP, which are some of the most powerful and widely-used languages in web development. 

🤔 - The <strong>primary function</strong> of this website is to present tables from a MySQL database in an intuitive and accessible manner. By leveraging these technologies, the project aims to provide a seamless user experience, making database interaction straightforward and efficient.

› This project was developed by Yannic Drews & Yanic Döpner for a project work in their training as IT specialists for application development - some parts of the project are on german because that's the language that was specified for the project work.

## 🪛 Features
› `PHP-MySQL-WebApp` provides a set of fundamental features that can assist you in handling databases and working with PHP, thereby facilitating your learning process on how to manage them effectively.
<br />

📢 › This project is designed to be <strong>compatible down to PHP 5.6</strong> and has been tested on both <strong>XAMPP</strong> and <strong>IntelliJ’s built-in web server</strong>.<br /><br />

It supports following <strong>features</strong>:
<ul>
  <li>📂 <strong>View MySQL Tables</strong>: With our dropdown menu on the right side, is it possible to switch between multiple tables based on the "buchladen" database.</li>
  <br />
  <li>📝 <strong>Add, Edit or Delete a Table Row</strong>: With the buttons on the right side at the table can you edit or delete a row inside it - with the button on the left above the table is it possible to add an entire new row.</li>
  <br />
  <li>📬 <strong>Write own SQL-SELECT Statements</strong>: With the small input text field on the right side above the table is it possible to write own MySQL-SELECT statements like "SELECT * FROM autoren" or else.</li>
  <br />
  <li>📋 <strong>Filter by Column</strong>: Click on the icon next to the column name in the table to filter by the corresponding column.</li>
  <br />
  <li>🔎 <strong>URL-Parameters</strong>: This little page works with URL parameters like `myurl.de/index.php?filterBy=column` to show specific MySQL tables.</li>
  <br />
  <li>🔩 <strong>GET & POST-Methods for PHP</strong>: We're also working with "GET" and "POST" Methods from PHP to reset the database if a button was pressed as example.</li>
  <br />
  <li>💡 <strong>Selectionsort-Algorithm</strong>: We're using the "Selectionsort"-Algorithm to sort our received data with PHP by the corresponding column name. However, we included also the better MySQL solution commented out.</li>
</ul>

## 🔨 Installation
› Before you can start exploring our small website for learning purposes, there are a few preparations you need to make.

💡 › You will need a <strong>MySQL Database</strong> and a <strong>web server capable of running PHP</strong>.<br /><br />

Then, follow these steps to ensure everything runs smoothly:
1. Execute our <strong>MySQL-Init Script</strong> [`buchladen.sql`](https://github.com/RazzerDE/PHP-MySQL-WebApp/blob/main/assets/sql/buchladen.sql) located in the `assets/sql/buchladen.sql` folder.
2. Set your <strong>correct MySQL login credentials</strong> in `assets/php/main.php`
3. Start the Webserver and have FUN!
