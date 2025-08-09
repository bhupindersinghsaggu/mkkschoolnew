<!-- <?php 
// $host = 'localhost';
// $dbname = 'school_reports';
// $username = 'root';
// $password = '';
// $conn = new mysqli($host, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

?>
-->
<?php
$host = 'localhost';
$username = 'u315669183_school_reports';
$password = '@Av4652B]m';
$dbname = 'u315669183_school_reports';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Database connection failed: " . $e->getMessage());
// }
?>

