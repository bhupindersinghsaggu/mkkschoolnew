<?php

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];

$conn = new mysqli("localhost", "root", "", "login system");
if ($conn->connect_error) {

    die('Connection Failed : ' . $conn->connect_error);
}