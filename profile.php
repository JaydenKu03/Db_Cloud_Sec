<?php
    require ('function/session.php');
    require ('function/db_connect.php');

    $conn = OpenCon();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/profile.css">
    <link rel="stylesheet" href="static/reusable.css">
    <title>My Profile</title>
</head>

<body>
    <?php
        include "template/navbar.php";
    ?>
    
    <div id="content-container">
        <div id="my-profile">
            <div >
                <img src="images/user_profile.png">
                <h1 class="title-font" id="user-name"> <?php echo $_SESSION["user_name"]; ?> </h1>
            </div>
            
            <div id="setting-container" class="simple-button"
                onclick="window.location.href='profile_details.php?id=<?php echo $_SESSION['user_ID']; ?>&role=<?php echo $_SESSION['user_role']; ?>'">
                Profile Settings
            </div>

        </div>

        <div id="information-container">
            <!-- General Render -->
            <?php
                if($_SESSION["user_role"] == "admin") {
                    $sql = "SELECT a.admin_ID, u.user_name, u.user_email, u.user_phone FROM [user] u
                            JOIN admin a ON u.user_ID = a.user_ID
                            WHERE a.admin_ID = '" . $_SESSION["user_ID"] . "'";
                }
                else if($_SESSION["user_role"] == "supervisor") {
                    $sql = "SELECT s.supervisor_ID, u.user_name, u.user_email, u.user_phone FROM [user] u
                            JOIN supervisor s ON u.user_ID = s.user_ID
                            WHERE s.supervisor_ID = '" . $_SESSION["user_ID"] . "'";
                }
                else {
                    $sql = "SELECT s.student_ID, s.specialization, u.user_name, u.user_email, u.user_phone FROM [user] u
                            JOIN student s ON u.user_ID = s.user_ID
                            WHERE s.student_ID = '" . $_SESSION["user_ID"] . "'";
                }

                $result = sqlsrv_query($conn, $sql);
                if($result === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                
                $rowcount = sqlsrv_has_rows($result);
                $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                if(!$rowcount){
                    echo "<script>alert('Information retrieve error'); window.location.href='index.php';</script>";
                }
            ?>
            
            <section id="user-details">
                <h2>User Details</h2>
                <h3>ID</h3>
                <p> <?php echo $_SESSION["user_ID"]; ?> </p>
                <h3>Role</h3>
                <p> <?php echo ucfirst($_SESSION["user_role"]); ?> </p>
                <?php
                    if($_SESSION["user_role"] == "student"){
                        echo "<h3>Specialization</h3>
                              <p>".$row['specialization']."</p>";
                    }
                ?>
                <h3>Email</h3>
                <p> <?php echo $row['user_email']; ?> </p>
                <h3>Phone</h3>
                <p> <?php echo $row['user_phone']; ?> </p>
            </section>

            <!-- Supervisor Render -->
            <?php
                if($_SESSION["user_role"] == "supervisor"){
                    $sql = "SELECT s.student_ID, u.user_name FROM [user] u
                    JOIN student s ON u.user_ID = s.user_ID
                    JOIN proposal p ON s.student_ID = p.student_ID
                    WHERE p.supervisor_ID = '" . $_SESSION["user_ID"] . "' AND p.proposal_status = 'approve' ";

                    $result = sqlsrv_query($conn, $sql);
                    if($result === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    
                    $rowcount = sqlsrv_has_rows($result);
                    echo '<section id="in-charge-details">';
                    echo '<h2>Supervised Student</h2>';
                    echo '<ul>';
                    if($rowcount) {
                        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                            echo '<li>'.$row['student_ID'].' - '.$row['user_name'].'</li>';
                        }
                    }else {
                        echo "<li>No student is under your supervision currently</li>";
                    }
                    echo '</ul>';
                    echo '</section>';
                }
            ?>

            <!-- Student Render -->
            <?php
                if($_SESSION["user_role"] == "student"){
                    $sql = "SELECT 
                                p.project_title, 
                                p.supervisor_ID,
                                p.co_supervisor_name,
                                p.proposed_by,
                                p.project_type, 
                                p.project_specialization,
                                p.project_category,
                                p.industry_collaboration,
                                p.file_address,
                                p.proposal_status,            
                                u.user_name AS supervisor_name
                            FROM proposal p
                            JOIN supervisor s ON p.supervisor_ID = s.supervisor_ID 
                            JOIN [user] u ON u.user_ID = s.user_ID
                            WHERE p.student_ID = '" . $_SESSION["user_ID"] . "'";

                    $result = sqlsrv_query($conn, $sql);
                    if($result === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    
                    $rowcount = sqlsrv_has_rows($result);
                    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                    echo '<section id="fyp-details">';
                    echo '<h2>FYP Details</h2>';
                    if($rowcount) {
                        echo '<h3>Title Name</h3>
                              <p>'.$row['project_title'].'</p><br>
                              <h3>Supervisor In Charge</h3>
                              <p>Dr. '.$row['supervisor_name'].'</p><br>
                              <h3>Supervisor ID</h3>
                              <p>'.$row['supervisor_ID'].'</p><br>
                              <h3>Co-Supervisor</h3>
                              <p>Dr. '.$row['co_supervisor_name'].'</p><br>
                              <h3>Proposed By</h3>
                              <p>'.$row['proposed_by'].'</p><br>
                              <h3>Project Type</h3>
                              <p>'.$row['project_type'].'</p><br>
                              <h3>Project Specialization</h3>
                              <p>'.$row['project_specialization'].'</p><br>
                              <h3>Project Category</h3>
                              <p>'.$row['project_category'].'</p><br>
                              <h3>Industry Collaboration</h3>
                              <p>'.$row['industry_collaboration'].'</p><br>
                              <h3>My Proposal</h3>
                              <p><a href = "'.$row['file_address'].'" target="_blank">View</a></p><br>
                              <h3>Title Status</h3>
                              <p>'.$row['proposal_status'].'</p>';
                    }else {
                        echo "You haven't submit any proposal yet";
                    }
                    echo '</section>';
                }
            ?>
        </div>
    </div>

    <?php
        include "template/footer.php";
    ?> 

</body>

</html>