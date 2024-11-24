<?php

$config = mysqli_connect("localhost", "root", "", "webapp") or die("DB Not Connected");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";