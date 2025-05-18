<?php
function viewStatus() {
    global $conn;

    $student_id = $_SESSION['user_ID'];
    $sql = "SELECT * FROM meeting_record WHERE student_ID = '$student_id'";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $title = $row['meeting_title'];
            $desc = $row['meeting_desc'];
            $date = $row['meeting_date'];
            $time = $row['meeting_time'];
            $status = $row['meeting_status'];

            echo "<tr>
                    <td>".$count."</td>
                    <td>".$title."</td>
                    <td>".$desc."</td>
                    <td>".$date."</td>
                    <td>".$time."</td>
                    <td>".$status."</td>
                  </tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
}
?>