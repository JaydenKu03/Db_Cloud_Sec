<?php
function manageMeetingRequest() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST['status'] as $meeting_id => $status) {

            $statusSql = "UPDATE meeting_record 
                          SET meeting_status = '$status' 
                          WHERE meeting_ID = '$meeting_id' 
                          AND supervisor_ID = '".$_SESSION['user_ID']."'"; 

            if (!$conn->query($statusSql)) {
                echo "<script>
                        alert('Error updating: " . $conn->error . "');
                        window.location.href = 'meeting_sv.php';
                      </script>";
                exit();
            }
        }

        echo "<script>
                alert('Updated Request!');
                window.location.href = 'meeting_sv.php';
              </script>";
        exit();
    }

    $query = "SELECT m.student_ID, p.student_name, m.meeting_title, m.meeting_desc, 
                     m.meeting_date, m.meeting_time, m.meeting_status, m.meeting_ID 
              FROM meeting_record m
              INNER JOIN proposal p ON m.student_ID = p.student_ID
              WHERE m.supervisor_ID = '".$_SESSION['user_ID']."' 
              AND m.meeting_status = 'Pending'"; 

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $meeting_id = $row['meeting_ID'];

            echo "<tr>
                    <td>".$count."</td>
                    <td>".$row['student_ID']."</td>
                    <td>".$row['student_name']."</td>
                    <td>".$row['meeting_title']."</td>
                    <td>".$row['meeting_desc']."</td>
                    <td>".$row['meeting_date']."</td>
                    <td>".$row['meeting_time']."</td>
                    <td>
                        <select name='status[" . $meeting_id . "]'>
                            <option value='Pending' " . ($row['meeting_status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                            <option value='Accept' " . ($row['meeting_status'] == 'Accept' ? 'selected' : '') . ">Accept</option>
                            <option value='Cancel' " . ($row['meeting_status'] == 'Cancel' ? 'selected' : '') . ">Cancel</option>
                        </select>
                    </td>
                  </tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='8'>No pending meeting requests found.</td></tr>";
    }

    $conn->close(); 
}
?>
