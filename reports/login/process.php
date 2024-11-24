<?php
session_start();
require_once('connection.php');

if (isset($_POST['login'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        header("location:login.php?Empty=Pleae fill in the blanks");
    } else {
        $query = "select * from users where username='" . $_POST['username'] . "' and password='" . $_POST['password'] . "'";
        $result = mysqli_query($con, $query);

        if (mysqli_fetch_assoc($result)) {
            $_SESSION['User'] = $_POST['username'];
            header("location:welcome.php");
        } else {
            header("location:index.php?invalid=Please enter correct user name and password");
        }
    }
}
