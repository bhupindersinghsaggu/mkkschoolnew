<?php
// auth.php - Enhanced authentication functions
require_once 'config.php';
require_once 'database.php';

class Auth
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function login($username, $password)
    {
        // Validate input
        if (empty($username) || empty($password)) {
            error_log("Login attempt with empty username or password");
            return false;
        }

        try {
            // Get user by username
            $query = "SELECT id, username, fullname, password, role, is_active FROM users WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify password
                if (password_verify($password, $user['password'])) {
                    if ($user['is_active'] == 1) {
                        // Set session variables
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION['logged_in'] = true;
                        $_SESSION['last_activity'] = time();

                        // Update last login
                        $this->updateLastLogin($user['id']);

                        // Log activity
                        $this->logActivity($user['id'], "User logged in");

                        return true;
                    } else {
                        error_log("Login attempt for inactive account: " . $username);
                        $this->logFailedAttempt($username);
                        return false;
                    }
                } else {
                    error_log("Invalid password for user: " . $username);
                    $this->logFailedAttempt($username);
                    return false;
                }
            } else {
                error_log("Login attempt for non-existent user: " . $username);
                $this->logFailedAttempt($username);
                return false;
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    
    private function isBruteForce($username)
    {
        try {
    // Get attempts within the last 30 minutes
            $query = "SELECT COUNT(*) as attempt_count FROM login_attempts 
                      WHERE username = :username AND attempt_time > DATE_SUB(NOW(), INTERVAL 30 MINUTE)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result['attempt_count'] >= MAX_LOGIN_ATTEMPTS);
        } catch (PDOException $e) {
            error_log("Brute force check error: " . $e->getMessage());
            return true; // Err on the side of caution
        }
    }

    private function updateLastLogin($user_id)
    {
        try {
            $query = "UPDATE users SET last_login = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update last login error: " . $e->getMessage());
        }
    }

    private function logFailedAttempt($username)
    {
        try {
            $query = "INSERT INTO login_attempts (username, attempt_time, ip_address) 
                      VALUES (:username, NOW(), :ip)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Failed attempt log error: " . $e->getMessage());
        }
    }

    public function logActivity($user_id, $activity)
    {
        try {
            $query = "INSERT INTO activity_log (user_id, activity, ip_address, user_agent) 
                      VALUES (:user_id, :activity, :ip, :ua)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
            $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $stmt->bindParam(':ua', $_SERVER['HTTP_USER_AGENT'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Activity log error: " . $e->getMessage());
        }
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // Check session expiration
            if (
                isset($_SESSION['last_activity']) &&
                (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)
            ) {
                $this->logout();
                return false;
            }
            $_SESSION['last_activity'] = time(); // Update last activity time
            return true;
        }
        return false;
    }

    public function logout()
    {
        if (isset($_SESSION['user_id'])) {
            $this->logActivity($_SESSION['user_id'], "User logged out");
        }

        // Unset all session variables
        $_SESSION = array();

        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();
    }

    public function hasPermission($required_role)
    {
        if (!$this->isLoggedIn()) return false;

        $user_role = $_SESSION['role'];

        // Super admin has access to everything
        if ($user_role == ROLE_SUPER_ADMIN) return true;

        // Admin has access to admin and student areas
        if ($user_role == ROLE_ADMIN && $required_role <= ROLE_ADMIN) return true;

        // Student only has access to student area
        if ($user_role == ROLE_TEACHER && $required_role == ROLE_TEACHER) return true;

        return false;
    }

    public function getRoleName($role_id)
    {
        switch ($role_id) {
            case ROLE_SUPER_ADMIN:
                return 'Super Admin';
            case ROLE_ADMIN:
                return 'Admin';
            case ROLE_TEACHER:
                return 'Teacher';
            default:
                return 'Unknown';
        }
    }
}
