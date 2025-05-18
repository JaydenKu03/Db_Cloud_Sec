<?php
require_once 'session.php';
require_once 'db_connect.php';

$conn = OpenCon();

function fetchStudent() {
    global $conn;

    if (isset($_SESSION['user_ID'])) {
        $supervisor_id = $_SESSION['user_ID'];
        
        $searchSql = "SELECT student_ID, student_name FROM proposal WHERE supervisor_ID = '$supervisor_id' AND proposal_status = 'approve'";
        $result = $conn->query($searchSql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $student_ID = $row['student_ID'];
                $student_name = $row['student_name'];
                $selected = (isset($_SESSION['selected_student_ID']) && $_SESSION['selected_student_ID'] == $student_ID) ? 'selected' : '';
                echo "<option value='$student_ID' $selected>$student_name</option>";
            }
        } else {
            echo "<option>No students found</option>";
        }
    } else {
        echo "<option>Supervisor not logged in</option>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_ID'])) {
    if (!isset($_SESSION['selected_student_ID']) || $_SESSION['selected_student_ID'] != $_POST['student_ID']) {
        $_SESSION['selected_student_ID'] = $_POST['student_ID'];
    }
    header("Location: ../goals_sv.php");
    exit();
}

?>
