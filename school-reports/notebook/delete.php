<?php
// session_start();
// include '../config/db.php';

// if (!isset($_SESSION['loggedin'])) {
//     header("Location: login.php");
//     exit;
// }

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM records WHERE id=$id");
header("Location: list.php");
exit;
?>
