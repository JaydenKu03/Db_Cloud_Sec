<?php
require_once 'db_connect.php';
$conn = OpenCon();

function viewProgress() {
    global $conn;

    if (isset($_SESSION['selected_student_ID'])) {
        $student_ID = $_SESSION['selected_student_ID'];

        $sql = "SELECT * FROM goal_and_progress WHERE student_ID = '$student_ID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['progress_date']."</td>
                        <td>".$row['current_progress']."</td>
                        <td>".$row['next_goal']."</td>
                        <td>".$row['comment']."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No progress records found for this student.</td></tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Please select a student.</td></tr>";
    }
}
?>
