<?php
function viewProgress() {
    global $conn;

    $student_id = $_SESSION['user_ID'];
    $sql = "SELECT * FROM goal_and_progress WHERE student_ID = '$student_id' ORDER BY progress_date ASC";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row['progress_date'];
            $current = $row['current_progress'];
            $next = $row['next_goal'];
            $comment = $row['comment'];

            echo "<tr>
                    <td>".$date."</td>
                    <td>".$current."</td>
                    <td>".$next."</td>
                    <td>".$comment."</td>
                  </tr>";
        }

    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
}
?>