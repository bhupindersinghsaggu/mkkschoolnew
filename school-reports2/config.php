<?php
// config.php - Database configuration and constants
session_start();

// Database configuration local
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'school-reports3');
// define('DB_USER', 'root');
// define('DB_PASS', '');

// Database configuration Web
define('DB_HOST', 'localhost');
define('DB_NAME', 'u315669183_schoolnew');
define('DB_USER', 'u315669183_schoolnew');
define('DB_PASS', 'Sa5msa5m@123');


//php my admin accsess 
// https://auth-db1001.hstgr.io/
//password: 



// User roles
define('ROLE_SUPER_ADMIN', 1);
define('ROLE_ADMIN', 2);
define('ROLE_TEACHER', 3);

// Application settings
define('APP_NAME', 'Computer Center Management System');
define('MAX_LOGIN_ATTEMPTS', 5);
define('SESSION_TIMEOUT', 1800); // 30 minutes

// Set security headers
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');



// Regenerate session ID to prevent session fixation
if (empty($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}
?>