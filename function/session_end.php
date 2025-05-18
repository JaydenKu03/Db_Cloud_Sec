<?php
session_start();
include('db_connect.php');
$conn = OpenCon();

// Log logout action if user was logged in
if (isset($_SESSION['user_ID']) && isset($_SESSION['user_role'])) {
    $ID = $_SESSION['user_ID'];
    $role = $_SESSION['user_role'];
    
    // Get base user_ID from role-specific table
    if ($role == 'admin') {
        $sql = "SELECT user_ID FROM admin WHERE admin_ID = ?";
    } 
    elseif ($role == 'supervisor') {
        $sql = "SELECT user_ID FROM supervisor WHERE supervisor_ID = ?";
    } 
    elseif ($role == 'student') {
        $sql = "SELECT user_ID FROM student WHERE student_ID = ?";
    }
    
    if (isset($sql)) {
        $stmt = sqlsrv_query($conn, $sql, array($ID));
        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Log the logout
            $logSql = "INSERT INTO user_activity_log (user_ID, action, ip_address, user_agent) 
                       VALUES (?, 'logout', ?, ?)";
            $logParams = array(
                $row['user_ID'],
                $_SERVER['REMOTE_ADDR'] ?? null,
                $_SERVER['HTTP_USER_AGENT'] ?? null
            );
            sqlsrv_query($conn, $logSql, $logParams);
        }
    }
}

// Clear session
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
             $params["path"], 
             $params["domain"], 
             $params["secure"], 
             $params["httponly"]);
}
session_destroy();

echo "<script>
        alert('Logout Successfully!');
        window.location.href = '../login.php';
      </script>";
?>