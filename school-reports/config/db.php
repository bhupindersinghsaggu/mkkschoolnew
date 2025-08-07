
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "school_reports";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>





<!-- <?php 
// $host = "localhost";
// $user = "u315669183_school_reports";
// $pass = "@Av4652B]m";
// $dbname = "u315669183_school_reports";
// $conn = new mysqli($host, $user, $pass, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// ?>


