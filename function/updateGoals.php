<?php 
require_once 'session.php';
require_once 'db_connect.php';
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = $_POST['update-date'];
    $progress = $_POST['update-progress'];
    $next = $_POST['update-goal'];
    $comment = 'Pending Comment';
    $student_id = $_SESSION['user_ID'];


    $goalSql = "INSERT INTO goal_and_progress (progress_date, current_progress, next_goal, comment, student_ID)
                VALUES ('$date', '$progress', '$next', '$comment', '$student_id')";

    if ($conn->query($goalSql)) {
        echo "<script>
                alert('Updated Progress!');
                window.location.href = '../goals.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error: Could not update the progress.');
                window.location.href = '../goals.php';
              </script>";
    }
}

$conn->close();
?>