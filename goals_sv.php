<?php
    require("function/session.php");
    require ('function/db_connect.php');
    require ('function/check_role.php');

    restrict_supervisor()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goals and Progress</title>
    <link rel="stylesheet" href="static/goals.css">
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/table.css">
</head>

<body>
    <?php
        include "template/navbar.php";
        require 'function/selectStudent.php';
    ?>

    <h1>Goals and Progress</h1>

    <div class="goals-container">

        <div class="select-container">
            <h2>Supervised Student Name</h2>
            <form action="function/selectStudent.php" method="POST" class="active-form">
                <label for="student_ID">Select Student:</label>
                <select name="student_ID" id="student_ID" required onchange="this.form.submit()">
                    <option value="" disabled selected>-- Choose Student --</option>
                    <?php 
                        fetchStudent(); 
                    ?>
                </select>
            </form>
        </div>

        <div class="progress-container">
            <h2>Progress Table</h2>
            <br />
            <table id="tracker">
                <br />
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Progress</th>
                        <th>Next Goal</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require 'function/viewGoals_sv.php';
                        viewProgress();
                    ?>
                </tbody>
            </table>    
        </div>

        <div class="update-container">
            <h2>Comment Form</h2>
            <form action="function/updateGoals_sv.php" method="POST" class="active-form">
                <label for="update-date">Select Student Progress Date:</label>
                <input type="date" id="update-date" name="update-date" required>

                <label for="update-comment">Comment:</label>
                <textarea id="update-comment" name="update-comment" maxlength="350" rows="4" placeholder="Enter Comment" required></textarea>
                
                <button type="submit">Submit Comment</button>
            </form>
        </div>
    </div>

    <?php include "template/footer.php"; ?>   
</body>
</html>
