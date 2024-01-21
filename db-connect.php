<?php

<!--
    This PHP script connects to a MySQL database using PDO,
    executes SQL statements from a file named '10260_assignment_4.sql',
    and sets the PDO error mode to exceptions for robust error handling.

    Database Connection Parameters:
    - Host: localhost (Change if the database is hosted elsewhere)
    - Database Name: sa000892525
    - Username: sa000892525
    - Password: Sa_20040517

    Note: Ensure that the '10260_assignment_4.sql' file contains valid SQL statements.
-->

$host = 'localhost';  // Change if your database is hosted elsewhere
$dbname = 'sa000892525';
$username = 'sa000892525';
$password = 'Sa_20040517';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlfile = '10260_assignment_4.sql';
    $file =  file_get_contents($sqlfile);

    $pdo ->exec($file);

?>
