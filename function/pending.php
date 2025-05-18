<?php
require_once 'db_connect.php';
$conn = OpenCon();

function viewPending(){
    global $conn;

    // Get filter values from GET parameters
    $searchName = isset($_GET['searchName']) ? $_GET['searchName'] : '';
    $searchSupervisor = isset($_GET['searchSupervisor']) ? $_GET['searchSupervisor'] : '';
    $searchSpecial = isset($_GET['specialization']) ? $_GET['specialization'] : 'all-specializations';

    // Base SQL query
    $sql = "SELECT * FROM proposal WHERE proposal_status = 'pending'";

    // Add filters if provided
    if (!empty($searchName)) {
        $sql .= " AND student_name LIKE '%" . $conn->real_escape_string($searchName) . "%'";
    }
    if (!empty($searchSupervisor)) {
        $sql .= " AND supervisor_name LIKE '%" . $conn->real_escape_string($searchSupervisor) . "%'";
    }
    if ($searchSpecial !== 'all-specializations') {
        $sql .= " AND specialization = '" . $conn->real_escape_string($searchSpecial) . "'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<tr>
                    <td>{$row['student_ID']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['project_title']}</td>
                    <td>{$row['specialization']}</td>
                    <td>{$row['proposed_by']}</td>
                    <td>Dr. {$row['supervisor_name']}</td>
                    <td><a href='{$row['file_address']}' target='_blank'>View</a></td>
                    <td><a href='proposalDetails.php?id={$row['proposal_ID']}' class='modern-button'>Details</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No records found</td></tr>";
    }
}
?>
