<?php 
require_once 'session.php';
require_once 'db_connect.php';

$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['selected_student_ID'])) {
        echo "<script>
                alert('Error: No student selected.');
                window.location.href = '../goals_sv.php';
              </script>";
        exit();
    }

    $student_ID = $_SESSION['selected_student_ID'];
    $progress_date = $_POST['update-date'];
    $comment = $_POST['update-comment'];

    $checkGoalSql = "SELECT * FROM goal_and_progress WHERE student_ID = '$student_ID' AND progress_date = '$progress_date'";
    $result = $conn->query($checkGoalSql);

    if ($result->num_rows > 0) {
        $updateSql = "UPDATE goal_and_progress SET comment = '$comment' WHERE student_ID = '$student_ID' AND progress_date = '$progress_date'";
        
        if ($conn->query($updateSql)) {
            echo "<script>
                    alert('Comment updated successfully!');
                    window.location.href = '../goals_sv.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: Unable to update comment.');
                    window.location.href = '../goals_sv.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Error: No progress found for the selected date.');
                window.location.href = '../goals_sv.php';
              </script>";
    }
}

$conn->close();
?>
