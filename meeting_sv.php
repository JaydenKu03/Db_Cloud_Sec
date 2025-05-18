<?php
    require("function/session.php");
    require ('function/db_connect.php');
    require ('function/check_role.php');

    restrict_supervisor();
    $conn = OpenCon();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meeting Management</title>
        <link rel="stylesheet" href="static/meeting.css">
        <link rel="stylesheet" href="static/base.css">
        <link rel="stylesheet" href="static/table.css">
    </head>

    <body>
        <?php include "template/navbar.php"; ?>

        <h1><b>Meeting Management</b></h1>
        <br />
        <div class="meeting-container">
            <div class="request-container">
                <h2>Appointment Request</h2>
                <form action="" method="POST" class="active-form">
                    <table id="meeting-status">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require 'function/manageRequest.php';
                                manageMeetingRequest();
                            ?>
                        </tbody>
                    </table>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>

        <?php include "template/footer.php"; ?>  
    </body>
</html>
