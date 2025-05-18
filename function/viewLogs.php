<?php
function viewLogs() {
    global $conn;

    $student_id = $_SESSION['user_ID'];
    $sql = "SELECT * FROM meeting_log WHERE student_ID = '$student_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $file = $row['file_address'];

            echo "<li>
                    <a href='$file' target='_blank'>" . basename($file) . "</a>
                  </li>";
        }

    } else {
        echo "<p>No logs found</p>";
    }
}
?>