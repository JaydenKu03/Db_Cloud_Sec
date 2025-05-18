<?php
require_once('../function/session.php');
require_once('../function/db_connect.php');

// Get the user ID and role from URL parameters
$user_ID = isset($_GET['id']) ? $_GET['id'] : '';
$role = isset($_GET['role']) ? $_GET['role'] : '';

// Get form data
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
$user_phone = isset($_POST['user_phone']) ? $_POST['user_phone'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validate password match if new password provided
if(!empty($new_password) && $new_password !== $confirm_password) {
    die("New passwords do not match");
}

// Connect to database
$conn = OpenCon();

// Get user_ID from role-specific table
if ($role == 'admin') {
    $sql_get_user_ID = "SELECT user_ID FROM admin WHERE admin_ID = ?";
}
elseif ($role == 'supervisor') {
    $sql_get_user_ID = "SELECT user_ID FROM supervisor WHERE supervisor_ID = ?";
}
elseif ($role == 'student') {
    $sql_get_user_ID = "SELECT user_ID FROM student WHERE student_ID = ?";
}  
else {
    die("Invalid role provided.");
}

// Execute query to get user_ID
$params = array($user_ID);
$stmt = sqlsrv_query($conn, $sql_get_user_ID, $params);

if($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if(!$row) {
    die("User not found");
}

$user_ID = $row['user_ID'];

// Prepare update query
$sql_update_user = "UPDATE [user] SET 
                   user_name = ?, 
                   user_email = ?, 
                   user_phone = ?";
                   
$params = array($user_name, $user_email, $user_phone);

// Add password to update if provided (with hashing)
if(!empty($new_password)) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql_update_user .= ", user_password = ?";
    $params[] = $hashed_password;
}

$sql_update_user .= " WHERE user_ID = ?";
$params[] = $user_ID;

// Execute update
$stmt = sqlsrv_query($conn, $sql_update_user, $params);

if($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Log the profile update
$action = !empty($new_password) ? 'password_update' : 'profile_update';
$ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

$logSql = "INSERT INTO user_activity_log (user_ID, action, ip_address, user_agent)
           VALUES (?, ?, ?, ?)";
$logParams = array($user_ID, $action, $ip_address, $user_agent);

$logStmt = sqlsrv_query($conn, $logSql, $logParams);

if($logStmt === false) {
    // Log the error but don't stop execution
    error_log("Failed to log activity: " . print_r(sqlsrv_errors(), true));
}

// Redirect back to profile page
header("Location: ../profile.php");
exit;
?>