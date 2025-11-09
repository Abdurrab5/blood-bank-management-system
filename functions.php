<?php
session_start();
$base_url = "http://localhost/bms/";

 
?>
<?php
// functions.php
if (session_status() === PHP_SESSION_NONE) session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function is_Admin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Redirect to login if not admin
        header("Location: ../login.php");
        exit;
    }
    // If admin, return true (optional)
    return true;
}
function is_Donor() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'donor') {
        // Redirect to login if not admin
        header("Location: ../login.php");
        exit;
    }
    // If admin, return true (optional)
    return true;
}
function is_Patient() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
        // Redirect to login if not admin
        header("Location: ../login.php");
        exit;
    }
    // If admin, return true (optional)
    return true;
}
function redirect($url) {
    header("Location: $url");
    exit;
}

// Simple flash helper
function flash($name = '', $message = '', $class = 'alert-success') {
    if(!empty($name)) {
        // set
        if(!empty($message)) {
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }
        // get
        elseif(isset($_SESSION[$name])) {
            $msg = "<div class='".$_SESSION[$name.'_class']."'>".$_SESSION[$name]."</div>";
            unset($_SESSION[$name], $_SESSION[$name.'_class']);
            return $msg;
        }
    }
    return '';
}

// sanitize
function e($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}
?>
<?php
if (!function_exists("check_role")) {
    function check_role($required_role) {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== $required_role) {
            header("Location: ../login.php");
            exit();
        }
    }
}

if (!function_exists("get_count")) {
    function get_count($table, $column, $value, $extra_condition = "") {
        global $conn;
        $sql = "SELECT COUNT(*) as total FROM $table WHERE $column = ?";
        if ($extra_condition) {
            $sql .= " AND $extra_condition";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $value);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }
}

if (!function_exists("get_patient_id")) {
    function get_patient_id($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT id FROM patients WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['id'] ?? null;
    }
}
function checkDonorEligibilityAndNotify($conn, $donor_id, $user_id) {
    // 1. Get last donation date
    $stmt = $conn->prepare("SELECT donation_date 
                            FROM donation_history 
                            WHERE donor_id=? 
                            ORDER BY donation_date DESC 
                            LIMIT 1");
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();
    $lastDonationRow = $stmt->get_result()->fetch_assoc();
    $lastDonationDate = $lastDonationRow['donation_date'] ?? null;

    // 2. Calculate eligibility date (90 days later)
    $eligibleDate = $lastDonationDate 
        ? date('Y-m-d', strtotime($lastDonationDate . ' +90 days')) 
        : date('Y-m-d');

    // 3. If today >= eligible date → donor eligible
    $today = date('Y-m-d');
    if ($today >= $eligibleDate) {
        $message = "You are now eligible to donate blood again. Please schedule your next donation.";

        // 4. Check if notification already exists for this eligibility
        $stmtCheck = $conn->prepare("
            SELECT id FROM notifications 
            WHERE user_id=? AND message=? 
        ");
        $stmtCheck->bind_param("is", $user_id, $message);
        $stmtCheck->execute();
        $exists = $stmtCheck->get_result()->fetch_assoc();

        // 5. If not exists → insert new notification
        if (!$exists) {
            $stmtInsert = $conn->prepare("
                INSERT INTO notifications (user_id, message, type, status) 
                VALUES (?, ?, 'info', 'unread')
            ");
            $stmtInsert->bind_param("is", $user_id, $message);
            $stmtInsert->execute();
        }
    }
}
