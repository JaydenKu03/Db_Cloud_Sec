<?php 
require_once 'session.php';
require_once 'db_connect.php';
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['meeting-title'];
    $desc = $_POST['meeting-description'];
    $date = $_POST['meeting-date'];
    $time = $_POST['meeting-time'];
    $status = 'Pending';
    $student_id = $_SESSION['user_ID'];
    
    $supervisorQuery = "SELECT supervisor_ID FROM proposal WHERE student_ID = '$student_id' AND proposal_status = 'approve' LIMIT 1";
    $result = $conn->query($supervisorQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $supervisor_id = $row['supervisor_ID'];


        $meetingSql = "INSERT INTO meeting_record (meeting_title, meeting_date, meeting_time, meeting_desc, student_ID, supervisor_ID, meeting_status)
                        VALUES ('$title', '$date', '$time', '$desc', '$student_id', '$supervisor_id', '$status')";

        if ($conn->query($meetingSql)) {
            echo "<script>
                    alert('Appoinment Requested!');
                    window.location.href = '../meeting.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error: Could not book the appointment.');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Error: No approved proposal.');
              </script>";
    }
}

$conn->close();
?>