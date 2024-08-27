<?php
session_start();
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','mkkschoo_bhupi');
define('DB_PASS','mP6-W}cCLk-q');
define('DB_NAME','mkkschoo_mkk');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
