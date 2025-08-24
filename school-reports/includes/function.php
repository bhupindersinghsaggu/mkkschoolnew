
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


<?php
/**
 * Returns time-based greeting (Good Morning, Good Afternoon, Good Evening)
 * @return string Appropriate greeting based on current time
 */
function getTimeBasedGreeting() {
    $current_hour = date('H'); // 24-hour format (0-23)
    
    if ($current_hour >= 5 && $current_hour < 12) {
        return "Good Morning";
    } elseif ($current_hour >= 12 && $current_hour < 17) {
        return "Good Afternoon";
    } elseif ($current_hour >= 17 && $current_hour < 21) {
        return "Good Evening";
    } else {
        return "Good Night";
    }
}

/**
 * Returns greeting with name
 * @param string $name Name to include in greeting
 * @return string Personalized greeting
 */
function getPersonalizedGreeting($name = '') {
    $greeting = getTimeBasedGreeting();
    return $name ? "$greeting, $name!" : "$greeting!";
}

/**
 * Returns greeting with emoji
 * @return string Greeting with appropriate emoji
 */
function getGreetingWithEmoji() {
    $current_hour = date('H');
    
    if ($current_hour >= 5 && $current_hour < 12) {
        return "Good Morning ☀️";
    } elseif ($current_hour >= 12 && $current_hour < 17) {
        return "Good Afternoon 🌤️";
    } elseif ($current_hour >= 17 && $current_hour < 21) {
        return "Good Evening 🌙";
    } else {
        return "Good Night 🌙";
    }
}
?>