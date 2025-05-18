<?php
require_once 'db_connect.php';
$conn = OpenCon();

function viewReject(){
    global $conn;

    // Get filter values from GET parameters
    $searchName = isset($_GET['searchName']) ? $_GET['searchName'] : '';
    $searchSupervisor = isset($_GET['searchSupervisor']) ? $_GET['searchSupervisor'] : '';
    $searchSpecial = isset($_GET['specialization']) ? $_GET['specialization'] : 'all-specializations';

    // Base SQL query
    $sql = "SELECT * FROM proposal WHERE proposal_status = 'reject'";

    // Add filters if provided
    if (!empty($searchName)) {
        $searchName = str_replace("'", "''", $searchName); // SQL Server escape
        $sql .= " AND student_name LIKE '%" . $searchName . "%'";
    }
    if (!empty($searchSupervisor)) {
        $searchSupervisor = str_replace("'", "''", $searchSupervisor); // SQL Server escape
        $sql .= " AND supervisor_name LIKE '%" . $searchSupervisor . "%'";
    }
    if ($searchSpecial !== 'all-specializations') {
        $searchSpecial = str_replace("'", "''", $searchSpecial); // SQL Server escape
        $sql .= " AND specialization = '" . $searchSpecial . "'";
    }

    $result = sqlsrv_query($conn, $sql);
    
    // Check for errors
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>
                    <td>".htmlspecialchars($row['student_ID'])."</td>
                    <td>".htmlspecialchars($row['student_name'])."</td>
                    <td>".htmlspecialchars($row['project_title'])."</td>
                    <td>".htmlspecialchars($row['specialization'])."</td>
                    <td>".htmlspecialchars($row['proposed_by'])."</td>
                    <td>".htmlspecialchars($row['supervisor_name'])."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
}
?>