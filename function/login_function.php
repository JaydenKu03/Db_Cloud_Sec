<?php
session_start();
include ('db_connect.php');
$conn = OpenCon();

if(isset($_POST['login'])){

    // Input validation start:
    // Sanitize input using trim, removes leading/trailing whitespace.
    $user_ID = trim($_POST['user_ID']);
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($user_ID) || empty($password)) {
        echo "<script>alert('Please fill in both User ID and Password');window.location.href='../login.php';</script>";
        exit();
    }

    // Ensure user_ID only contains digits
    if (!preg_match('/^\d+$/', $user_ID)) {
        echo "<script>alert('Invalid User ID format');window.location.href='../login.php';</script>";
        exit();
    }

    $userType = $user_ID[0];
    $sql = "";
    $params = [$user_ID];

    switch($user_ID[0]){
        case '1': // student
            $sql = "SELECT u.user_ID, u.user_name, u.user_password, u.user_role, s.student_ID AS specific_ID 
                    FROM [user] u
                    JOIN student s ON u.user_ID = s.user_ID
                    WHERE s.student_ID = ?";
            break;

        case '5': // supervisor
            $sql = "SELECT u.user_ID, u.user_name, u.user_password, u.user_role, s.supervisor_ID AS specific_ID 
                    FROM [user] u
                    JOIN supervisor s ON u.user_ID = s.user_ID
                    WHERE s.supervisor_ID = ?";
            break;

        case '8': // admin
            $sql = "SELECT u.user_ID, u.user_name, u.user_password, u.user_role, a.admin_ID AS specific_ID 
                    FROM [user] u
                    JOIN admin a ON u.user_ID = a.user_ID
                    WHERE a.admin_ID = ?";
            break;

        default:
            echo "<script>alert('Invalid ID');window.location.href='../login.php';</script>";
            exit();
    }

    $options = ["Scrollable" => SQLSRV_CURSOR_KEYSET];
    $stmt = sqlsrv_prepare($conn, $sql, $params, $options); //sqlsrv_prepare() will handle parameterized input internally

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        die(print_r(sqlsrv_errors(), true));
    }

    $rowcount = sqlsrv_num_rows($stmt);

    if ($rowcount === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($rowcount == 1){
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Password verification
        if (password_verify($password, $row['user_password'])) {
            $_SESSION["user_name"] = $row['user_name'];
            $_SESSION["user_ID"] = $row['specific_ID'];
            $_SESSION["user_role"] = $row['user_role'];

            // ---------- Successful Login Audit Logging ----------
            $userId = $row['user_ID'];
            $action = 'login';
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

            $logSql = "INSERT INTO user_activity_log (user_ID, action, ip_address, user_agent)
                       VALUES (?, ?, ?, ?)";
            $logParams = [$userId, $action, $ip_address, $user_agent];

            $logStmt = sqlsrv_query($conn, $logSql, $logParams);

            if ($logStmt === false) {
                error_log(print_r(sqlsrv_errors(), true));
            }

            header('Location:../index.php');
        } else {
            // ---------- Failed Login Audit Logging ----------
            $userId = $row['user_ID'];
            $action = 'failed_login';
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

            $logSql = "INSERT INTO user_activity_log (user_ID, action, ip_address, user_agent)
                       VALUES (?, ?, ?, ?)";
            $logParams = [$userId, $action, $ip_address, $user_agent];

            $logStmt = sqlsrv_query($conn, $logSql, $logParams);

            if ($logStmt === false) {
                error_log(print_r(sqlsrv_errors(), true));
            }

            echo "<script>alert('Invalid password');window.location.href='../login.php';</script>";
        }

    } else {
        // User not found - we can't log this as a failed attempt because we don't have a valid user_id
        echo "<script>alert('User not found');window.location.href='../login.php';</script>";
    }

} else {
    echo "<script>alert('Page Not Accessible');window.location.href='../login.php';</script>";
}
?>