

<?php 
$host = 'localhost';
$dbname = 'u315669183_school_reports';
$username = 'u315669183_school_reports';
$password = 'l2>C@]h|k';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


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
