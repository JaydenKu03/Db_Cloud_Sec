<?php
require_once 'db_connect.php';
$conn = OpenCon(); 

function viewData(){
    global $conn;

    // Get filter parameters from the URL (GET request)
    $searchName = isset($_GET['searchName']) ? $_GET['searchName'] : '';
    $searchSupervisor = isset($_GET['searchSupervisor']) ? $_GET['searchSupervisor'] : '';
    $searchSpecial = isset($_GET['specialization']) ? $_GET['specialization'] : 'all-specializations';

    // Base SQL query
    $sql = "SELECT * FROM proposal WHERE proposal_status = 'approve'";

    // Apply filters based on user input
    if ($searchName) {
        $searchName = str_replace("'", "''", $searchName); // SQL Server escape for single quotes
        $sql .= " AND student_name LIKE '%$searchName%'";
    }

    if ($searchSupervisor) {
        $searchSupervisor = str_replace("'", "''", $searchSupervisor); // SQL Server escape for single quotes
        $sql .= " AND supervisor_name LIKE '%$searchSupervisor%'";
    }
    
    if ($searchSpecial != 'all-specializations') {
        $searchSpecial = str_replace("'", "''", $searchSpecial); // SQL Server escape for single quotes
        $sql .= " AND specialization = '$searchSpecial'";
    }

    // Execute the SQL query
    $result = sqlsrv_query($conn, $sql);
    
    // Check for errors
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Check if any results are found
    if (sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $studID = $row['student_ID'];
            $studName = $row['student_name'];
            $title = $row['project_title'];
            $specialization = $row['specialization'];
            $proposeBy = $row['proposed_by'];
            $supervisor = $row['supervisor_name'];

            // Display the filtered data in a table row
            echo "<tr>
                    <td>".htmlspecialchars($studID)."</td>
                    <td>".htmlspecialchars($studName)."</td>
                    <td>".htmlspecialchars($title)."</td>
                    <td>".htmlspecialchars($specialization)."</td>
                    <td>".htmlspecialchars($proposeBy)."</td>
                    <td>".htmlspecialchars($supervisor)."</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
}
?>