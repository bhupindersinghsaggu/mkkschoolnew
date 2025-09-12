
<!-- teacher count from database -->
<?php
$count_query = "SELECT COUNT(*) as total_teachers FROM users";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_teachers = $count_data['total_teachers'];




// notebook check count from database 
// $count_query = "SELECT COUNT(*) as notebook_count FROM records";
$count_query= "SELECT COUNT(*) FROM records WHERE session = '2025-26'";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$notebook_count = $count_data['notebook_count'];


// class show count from database 
$count_query = "SELECT COUNT(*) as class_show_count FROM class_show";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$class_show_count = $count_data['class_show_count'];


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
// Set Indian time zone at the top of the file
date_default_timezone_set('Asia/Kolkata');

/**
 * Returns time-based greeting (Good Morning, Good Afternoon, Good Evening)
 * Uses Indian Standard Time (IST)
 * @return string Appropriate greeting based on current time
 */
function getTimeBasedGreeting() {
    $current_hour = date('H'); // 24-hour format (0-23) in IST
    
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

/**
 * Get current Indian time with format
 * @param string $format Date format (default: 'h:i A')
 * @return string Formatted Indian time
 */
function getIndianTime($format = 'h:i A') {
    $original_timezone = date_default_timezone_get();
    date_default_timezone_set('Asia/Kolkata');
    $time = date($format);
    date_default_timezone_set($original_timezone);
    return $time;
}
?>

<?php
/**
 * Get the latest teacher added to the system
 * @return array|null Teacher data or null if no teachers found
 */
function getLatestTeacher() {
    global $conn;
    
    $query = "SELECT td.teacher_name, td.teacher_id, td.teacher_type, td.profile_pic, 
                     td.subject, u.created_at
              FROM teacher_details td
              JOIN users u ON td.user_id = u.id
              WHERE u.role = 'teacher'
              ORDER BY u.created_at DESC 
              LIMIT 1";
    
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

// Get teacher count
$count_query = "SELECT COUNT(*) as total_teachers FROM teacher_details";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_teachers = $count_data['total_teachers'];

// Get latest teacher
$latest_teacher = getLatestTeacher();


