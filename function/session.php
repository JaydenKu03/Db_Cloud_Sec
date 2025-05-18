<?php
    session_start();

    if(!isset($_SESSION["user_ID"])){
        echo "<script>
                alert('Please Login!');
                window.location.href = './login.php';
              </script>";
        exit();
    }
?>

