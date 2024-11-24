<?php

$con = mysqli_connect('127.0.0.1:3306', 'u315669183_webapp', 'Sa5msa5m@', 'u315669183_webapp');


if (!$con) {

    die('Please check your connection' . mysqli_error($con));
}
