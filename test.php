<?php

    include ('function/db_connect.php');
    $conn = OpenCon();
    
    $tsql = "SELECT * FROM [user]";
    $result = sqlsrv_query($conn, $tsql);

    if($result) {
        echo "<table border = 1>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                    <tr>
                </thead>
                <tbody>";
        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['user_ID']}</td>
                    <td>{$row['user_name']}</td>
                    <td>{$row['user_role']}</td>
                </tr>";
        }
        echo "</tbody>
            </table>";
    }

    // $password = "supervisor123";

    // $hashedpass= password_hash($password, PASSWORD_BCRYPT);
    // echo $hashedpass;


    // DROP TABLE user_activity_log
    // DROP TABLE assessment
    // DROP TABLE announcement
    // DROP TABLE [event]
    // DROP TABLE goal_and_progress
    // DROP TABLE meeting_log
    // DROP TABLE meeting_record
    // DROP TABLE proposal
    // DROP TABLE student
    // DROP TABLE supervisor
    // DROP TABLE [admin]
    // DROP TABLE [user]
?>