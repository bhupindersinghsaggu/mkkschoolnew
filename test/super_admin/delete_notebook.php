
<?php
// session_start();
require_once '../includes/auth_check.php';
require_once  '../config/database.php';
require_once  '../config/functions.php';
// if (!isset($_SESSION['loggedin'])) {
//     header("Location: login.php");
//     exit;
// }

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM records WHERE id=$id");
header("Location: list.php");
exit;
?>
