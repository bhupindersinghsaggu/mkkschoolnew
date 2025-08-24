
<!-- teacher count from database -->
<?php
$count_query = "SELECT COUNT(*) as total_teachers FROM users";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_teachers = $count_data['total_teachers'];




// notebook check count from database 
$count_query = "SELECT COUNT(*) as notebook_count FROM records";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$notebook_count = $count_data['notebook_count'];
?>

<?php

/**Get current date in various formats*/

function getCurrentDate($format = 'F j, Y') {
    return date($format);
}

/** Get current year */
function getCurrentYear() {
    return date('Y');
}

/*** Get current date with time*/
function getCurrentDateTime($format = 'F j, Y, g:i a') {
    return date($format);
}

/*** Get current day and date*/
function getCurrentDayDate() {
    return date('l, F j, Y');
}

/*** Get current date in Indian format (DD-MM-YYYY)*/
function getCurrentDateIndian() {
    return date('d-m-Y');
}

/**
 * Get current date in SQL format (YYYY-MM-DD)*/
function getCurrentDateSQL() {
    return date('Y-m-d');
}
?>
