<?php
require("db_connect.php");

$conn = OpenCon();

if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $password = $conn->real_escape_string($_POST['password']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role = $conn->real_escape_string($_POST['role']);

    // Insert into user table
    $sql1 = "INSERT INTO user (
    user_name, 
    user_password, 
    user_email, 
    user_phone, 
    user_role) 
    VALUES (
    '$name', 
    '$password', 
    '$email', 
    '$phone', 
    '$role')";

    if ($conn->query($sql1) === TRUE) {
        // Get the last inserted user_ID
        $user_ID = mysqli_insert_id($conn);

        // If role is supervisor, insert into supervisor table
        
        if ($role == 'supervisor') {
            $sql2 = "INSERT INTO supervisor (user_ID) VALUES ('$user_ID')";
            if ($conn->query($sql2) === TRUE) {
                $supervisor_ID = mysqli_insert_id($conn);
                echo '<script>alert("Supervisor has been registered and Supervisor ID is: {'.$supervisor_ID.'}")
                        window.location.href = "../admin_register.php";
                </script>';
                exit;
            } else {
                echo "Error inserting supervisor: " . $conn->error;
            }
        } 
        // If role is admin, insert into admin table (assuming it exists)
        else if ($role == 'admin') {
            $sql3 = "INSERT INTO admin (user_ID) VALUES ('$user_ID')"; // Ensure you have an 'admin' table

            if ($conn->query($sql3) === TRUE) {
                $admin_ID = mysqli_insert_id($conn);
                echo '<script>alert("Admin has been registered and Admin ID is : {'.$admin_ID.'}");
                        window.location.href = "../admin_register.php";
                    </script>';
                exit;
            } else {
                echo "Error inserting admin: " . $conn->error;
            }
        }
    } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
    }
} else {
    echo "<script>alert('An error occurred. Please try again.')</script>";
    exit;
}

CloseCon($conn);
?>
