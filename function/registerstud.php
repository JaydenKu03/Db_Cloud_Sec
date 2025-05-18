<?php
require_once 'db_connect.php';
$conn = OpenCon();

$status = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $password = $_POST['password'];
    $hashedpass= password_hash($password, PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];

    // Insert into user table
    $userSql = "INSERT INTO [user] (user_name, user_password, user_email, user_phone, user_role)
                VALUES (?, ?, ?, ?, 'student')";
    $userParams = [$name, $hashedpass, $email, $phone];
    $userInsert = sqlsrv_query($conn, $userSql, $userParams);

    if($userInsert){
        // Get the user_ID for the newly inserted user
        $sql = "SELECT user_ID FROM [user] WHERE user_name = ? AND user_email = ?";
        $result = sqlsrv_query($conn, $sql, [$name, $email]);
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $userId = $row['user_ID'];

        // Insert into student table
        $studSql = "INSERT INTO student (specialization, user_ID) VALUES (?, ?)";
        $studInsert = sqlsrv_query($conn, $studSql, [$specialization, $userId]);
        $status = $studInsert ? true : false;

        // Get student_ID
        $sql = "SELECT s.student_ID FROM student s JOIN [user] u ON u.user_ID = s.user_ID WHERE u.user_ID = ?";
        $result = sqlsrv_query($conn, $sql, [$userId]);
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $student_ID = $row['student_ID'];
    }

    if($status){
        echo "<script>
                alert('You have successfully registered your account. This is your ID: {$student_ID}');
                window.location.href = '../login.php';
              </script>";
    } else {
        echo '<script>
                alert("Registration failed. Please try again.");
                window.location.href = "../student_register.php";
              </script>';
    }
}
?>
