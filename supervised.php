<?php
    require ('function/session.php');
    require ('function/db_connect.php');
    require ('function/insert_supervised.php');
    require ('function/check_role.php');

    restrict_supervisor();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervised Student</title>
    <link rel="stylesheet" href="static/supervised.css">
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/reusable.css">
</head>

<body>
    <?php
        include "template/navbar.php";
    ?>

    <h1 class="title-font">Supervised Student</h1>
    <div class="containerwrapper">
        <div class="supervisor-container">
            <img src="images/file.png" alt="profile picture" title="user profile picture">
            <ul>
                <li><strong>Supervisor Name:</strong></li>
                <li><?php echo $_SESSION["user_name"]; ?></li>
            </ul>
            <ul>
                <li><strong>Total supervised Student:</strong></li>
                <li>
                    <?php
                    echo $row1['total_students'];
                    ?>
                </li>
            </ul>
            <ul>
                <li><strong>ID:</strong></li>
                <li><?php echo $_SESSION["user_ID"]; ?></li>
            </ul>
        </div>
        <div class="supervised-container">
        <?php 
    while ($row2 = mysqli_fetch_assoc($result2)) {
        echo '<div class="student-info">
                <ul>
                    <li><strong>Student Name:</strong></li>
                    <li>' . $row2['student_name'] . '</li>
                </ul>
                <ul>
                    <li><strong>Project Title:</strong></li>
                    <li>' . $row2['project_title'] . '</li>
                </ul>
                <ul>
                    <li><strong>Student ID:</strong></li>
                    <li>' . $row2['student_ID'] . '</li>
                </ul>
                <ul>
                    <li><strong>Assessment Grade:</strong></li>
                    <li>' . $row2['final_grade'] . '</li>
                </ul>
                <ul>
            <li><strong>Assessment File:</strong></li>
            <li>
                <a href="store_assessment/' . $row2['assessment_file'] . '" download>' . $row2['assessment_file'] . '</a>
            </li>
        </ul>
              </div>';
    } 
    ?>
    </div>

    </div>

    <?php
        include "template/footer.php";
    ?>  
</body>

</html>