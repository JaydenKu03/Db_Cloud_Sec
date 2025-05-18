<?php
    require("function/session.php");
    require ('function/db_connect.php');
    require ('function/check_role.php');

    restrict_student();
    $conn = openCon();
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
        ?>

        <h1>Goals and Progress</h1>

        <div class="goals-container">
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
                            require 'function/viewGoals.php';
                            viewProgress();
                        ?>
                    </tbody>
                </table>    
            </div>

            <div class="update-container">
                    <h2>Update Form</h2>
                    <form action="function/updateGoals.php" method="POST" class="active-form">

                        <label for="update-date">Date:</label>
                        <input type="date" id="update-date" name="update-date" required>

                        <label for="update-progress">Progress:</label>
                        <textarea id="update-progress" name="update-progress" maxlength="350" rows="4" placeholder="Enter Current Progress" required></textarea>

                        <label for="update-goal">Next Goal:</label>
                        <textarea id="update-goal" name="update-goal" maxlength="350" rows="4" placeholder="Enter Next Goal" required></textarea>
                        
                        <button type="submit">Submit Update</button>
                    </form>
            </div>
        </div>

        
        <?php
            include "template/footer.php";
        ?> 

    </body>
</html>
