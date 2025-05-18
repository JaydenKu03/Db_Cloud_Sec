<?php
    require("session.php");
    require ('db_connect.php');

    if($_SESSION['user_role'] != "admin") {
        die("You Don't Have Access To This Page");
    }

    if(isset($_POST['submit_announcement'])) {
        $title = $_POST['announcement_title'];
        $content = $_POST['announcement_content'];
        $post_by = $_SESSION['user_name'];
        $admin_ID = $_SESSION['user_ID'];

        if(!empty($title) && !empty($content) && !empty($post_by) && !empty($admin_ID)) {
            $conn = openCon();
            $sql = "INSERT INTO announcement (`post_by`, `announcement_title`, `announcement_content`, `admin_ID`)
                    VALUES ('$post_by', '$title', '$content', '$admin_ID')";
            $result = $conn->query($sql);

            if($result) {
                echo '<script>alert("Announcement Post Successfully!"); window.location.href="../announcement.php";</script>';
            } else {
                echo '<script>alert("Announcement Post Failed!"); window.location.href="../announcement.php";</script>';
            }
        }else {
            echo '<script>alert("Cannot Post Empty Announcement!!"); window.location.href="../announcement.php";</script>';
        }

    }else if(isset($_POST['submit_event'])) {
        $date = $_POST['event_date'];
        $title = $_POST['event_title'];
        $post_by = $_SESSION['user_name'];
        $admin_ID = $_SESSION['user_ID'];

        $current_date = date("Y-m-d");
        if (strtotime($date) < strtotime($current_date)) {
            echo '<script>alert("Invalid Date"); window.location.href="../announcement.php";</script>';
            exit();
        }

        if(!empty($date) && !empty($title) && !empty($post_by) && !empty($admin_ID)) {
            $conn = openCon();
            $sql = "INSERT INTO event (`post_by`, `event_date`, `event_title`, `admin_ID`)
                    VALUES ('$post_by', '$date', '$title', '$admin_ID') ";
            $result = $conn->query($sql);

            if($result) {
                echo '<script>alert("Announcement Post Successfully!"); window.location.href="../announcement.php";</script>';
            } else {
                echo '<script>alert("Announcement Post Failed!"); window.location.href="../announcement.php";</script>';
            }
        }else {
            echo '<script>alert("Cannot Post Empty Event!"); window.location.href="../announcement.php";</script>';
        }
    }else {
        '<script>alert("Submission Error"); window.location.href="../announcement.php";</script>';
    }
?>