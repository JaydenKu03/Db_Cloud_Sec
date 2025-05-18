<?php
    require("function/session.php");
    require ('function/db_connect.php');
    require ('function/check_role.php');

    restrict_admin();

    $conn = openCon();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/view_profile.css">
    <link rel="stylesheet" href="static/reusable.css">
    <title>View Profile</title>
</head>

<body>
    <?php
        include "template/navbar.php";
    ?>
    
    <div class="form-wrapper">
        <div class="form-container">
            <h1>User Information</h1>
            <form action="function/update_user.php?id=<?php echo $_GET['id']; ?>&name=<?php echo $_GET['name']; ?>&role=<?php echo $_GET['role']; ?>" method="post">
                <!-- General Render -->
                <div class="form-section">
                    <?php
                        if($_GET["role"] == "admin") {
                            $sql = "SELECT a.admin_ID, u.user_name, u.user_password, u.user_email, u.user_phone, u.user_role FROM user u
                                    JOIN admin a ON u.user_ID = a.user_ID
                                    WHERE a.admin_ID = '" . $_GET["id"] . "'";
                        }
                        else if($_GET["role"] == "supervisor") {
                            $sql = "SELECT s.supervisor_ID, u.user_name, u.user_password, u.user_email, u.user_phone FROM user u
                                    JOIN supervisor s ON u.user_ID = s.user_ID
                                    WHERE s.supervisor_ID = '" . $_GET["id"] . "'";
                        }
                        else if($_GET["role"] == "student"){
                            $sql = "SELECT s.student_ID, s.specialization, u.user_name, u.user_password, u.user_email, u.user_phone FROM user u
                                    JOIN student s ON u.user_ID = s.user_ID
                                    WHERE s.student_ID = '" . $_GET["id"] . "'";
                        }
                        else {
                            echo "Invalid role provided.";
                            exit;
                        }

                        $result = $conn->query($sql);
                        $rowcount = mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);

                        if($rowcount != 1){
                            echo "<script>alert('Information retrieve error'); window.location.href='index.php';</script>";
                        }
                    ?>

                    <h3>General Information</h3>
                    <div class="form-group">
                        <label for="user_name">Name:</label>
                        <input type="text" id="user_name" name="user_name" value="<?php echo $row["user_name"] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="user_id">ID:</label>
                        <input type="number" id="user_id" name="user_id" value="<?php echo $_GET["id"] ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email:</label>
                        <input type="email" id="user_email" name="user_email" value="<?php echo $row["user_email"] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="user_phone">Phone:</label>
                        <input type="number" id="user_phone" name="user_phone" value="<?php echo $row["user_phone"] ?>" required>
                    </div>


                    <?php
                        if($_GET['role'] == 'student') {
                            echo '<div class="form-group">
                                    <label for="specialization">Specialization</label>
                                    <select name="specialization" id="specialization" required>
                                        <option value="" disabled>Select Specialization</option>
                                        <option value="Computer Science" '.($row["specialization"] == "Computer Science" ? "selected" : "").'>Computer Science</option>
                                        <option value="Cybersecurity" '.($row["specialization"] == "Cybersecurity" ? "selected" : "").'>Cybersecurity</option>
                                        <option value="Game Development" '.($row["specialization"] == "Game Development" ? "selected" : "").'>Game Development</option>
                                        <option value="Data Science" '.($row["specialization"] == "Data Science" ? "selected" : "").'>Data Science</option>
                                        <option value="Software Engineering" '.($row["specialization"] == "Software Engineering" ? "selected" : "").'>Software Engineering</option>
                                        <option value="Information System" '.($row["specialization"] == "Information System" ? "selected" : "").'>Information System</option>
                                    </select>
                                </div>';
                        }
                    ?>

                    <div class="form-group">
                        <label for="user_password">Password:</label>
                        <input type="text" id="user_password" name="user_password" value="<?php echo $row["user_password"] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="user_role">Role:</label>
                        <input type="text" id="user_role" name="user_role" value="<?php echo $_GET["role"] ?>" required readonly>
                    </div>
                </div>


                <!-- Student Render -->
                <?php
                    if ($_GET['role'] == "student") {
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
                                JOIN user u ON u.user_ID = s.user_ID
                                WHERE p.student_ID = '" . $_GET["id"] . "'";

                    $result = $conn->query($sql);
                    $rowcount = mysqli_num_rows($result);

                    echo '<div class="form-section">
                            <h3>FYP Information</h3>';
                    if ($rowcount > 0) {
                        $row = mysqli_fetch_array($result);
                ?>
                        <div class="form-group">
                            <label for="project_title">Title Name:</label>
                            <input type="text" id="project_title" name="project_title" value="<?php echo htmlspecialchars($row['project_title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="supervisor_name">Supervisor In Charge:</label>
                            <input type="text" id="supervisor_name" name="supervisor_name" value="<?php echo htmlspecialchars($row['supervisor_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="supervisor_ID">Supervisor ID:</label>
                            <input type="number" id="supervisor_ID" name="supervisor_ID" value="<?php echo htmlspecialchars($row['supervisor_ID']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="co_supervisor_name">Co-Supervisor:</label>
                            <input type="text" id="co_supervisor_name" name="co_supervisor_name" value="<?php echo htmlspecialchars($row['co_supervisor_name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="proposed_by">Propose By:</label>
                            <select id="proposed_by" name="proposed_by" required>
                                <option value="Student" <?php echo ($row["proposed_by"] == "Student" ? "selected" : ""); ?>>Student-proposed</option>
                                <option value="Lecture" <?php echo ($row["proposed_by"] == "Lecture" ? "selected" : ""); ?>>Lecture-proposed</option>
                                <option value="Industry" <?php echo ($row["proposed_by"] == "Industry" ? "selected" : ""); ?>>Industry-proposed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="project_type">Project Type:</label>
                            <select id="project_type" name="project_type" required>
                                <option value="Application" <?php echo ($row["project_type"] == "Application" ? "selected" : ""); ?>>Application-based</option>
                                <option value="Research" <?php echo ($row["project_type"] == "Research" ? "selected" : ""); ?>>Research-based</option>
                                <option value="Application and Research" <?php echo ($row["project_type"] == "Application and Research" ? "selected" : ""); ?>>Application and Research-based</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="project_specialization">Project Specialization:</label>
                            <select id="project_specialization" name="project_specialization" required>
                                <option value="Computer Science" <?php echo ($row["project_specialization"] == "Computer Science" ? "selected" : ""); ?>>Computer Science</option>
                                <option value="Cybersecurity" <?php echo ($row["project_specialization"] == "Cybersecurity" ? "selected" : ""); ?>>Cybersecurity</option>
                                <option value="Game Development" <?php echo ($row["project_specialization"] == "Game Development" ? "selected" : ""); ?>>Game Development</option>
                                <option value="Data Science" <?php echo ($row["project_specialization"] == "Data Science" ? "selected" : ""); ?>>Data Science</option>
                                <option value="Software Engineering" <?php echo ($row["project_specialization"] == "Software Engineering" ? "selected" : ""); ?>>Software Engineering</option>
                                <option value="Information System" <?php echo ($row["project_specialization"] == "Information System" ? "selected" : ""); ?>>Information System</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="project_category">Project Category:</label>
                            <select id="project_category" name="project_category" required>
                                <option value="Critical System" <?php echo ($row["project_category"] == "Critical System" ? "selected" : ""); ?>>Critical System</option>
                                <option value="Application Software" <?php echo ($row["project_category"] == "Application Software" ? "selected" : ""); ?>>Application Software</option>
                                <option value="Software Tools & Utilities" <?php echo ($row["project_category"] == "Software Tools & Utilities" ? "selected" : ""); ?>>Software Tools & Utilities</option>
                                <option value="Service Oriented Computing" <?php echo ($row["project_category"] == "Service Oriented Computing" ? "selected" : ""); ?>>Service Oriented Computing</option>
                                <option value="Data Engineering" <?php echo ($row["project_category"] == "Data Engineering" ? "selected" : ""); ?>>Data Engineering</option>
                                <option value="Data Analytics" <?php echo ($row["project_category"] == "Data Analytics" ? "selected" : ""); ?>>Data Analytics</option>
                                <option value="Cryptography and Data Security" <?php echo ($row["project_category"] == "Cryptography and Data Security" ? "selected" : ""); ?>>Cryptography and Data Security</option>
                                <option value="Investigation and Analysis" <?php echo ($row["project_category"] == "Investigation and Analysis" ? "selected" : ""); ?>>Investigation and Analysis</option>
                                <option value="Security and Defence" <?php echo ($row["project_category"] == "Security and Defence" ? "selected" : ""); ?>>Security and Defence</option>
                                <option value="Game Software Development (GSD)" <?php echo ($row["project_category"] == "Game Software Development (GSD)" ? "selected" : ""); ?>>Game Software Development (GSD)</option>
                                <option value="Game Algorithm Research (GAR)" <?php echo ($row["project_category"] == "Game Algorithm Research (GAR)" ? "selected" : ""); ?>>Game Algorithm Research (GAR)</option>
                                <option value="Game Design Prototyping (GDP)" <?php echo ($row["project_category"] == "Game Design Prototyping (GDP)" ? "selected" : ""); ?>>Game Design Prototyping (GDP)</option>
                                <option value="IT Infrastructure" <?php echo ($row["project_category"] == "IT Infrastructure" ? "selected" : ""); ?>>IT Infrastructure</option>
                                <option value="Transaction Processing Systems" <?php echo ($row["project_category"] == "Transaction Processing Systems" ? "selected" : ""); ?>>Transaction Processing Systems</option>
                                <option value="Intelligent Systems" <?php echo ($row["project_category"] == "Intelligent Systems" ? "selected" : ""); ?>>Intelligent Systems</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="industry_collaboration">Industry Collaboration:</label>
                            <select id="industry_collaboration" name="industry_collaboration" required>
                                <option value="no" <?php echo ($row["industry_collaboration"] == "no" ? "selected" : ""); ?>>No</option>
                                <option value="yes" <?php echo ($row["industry_collaboration"] == "yes" ? "selected" : ""); ?>>Yes</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="file_address">Proposal:</label>
                            <a href="<?php echo htmlspecialchars($row['file_address']);?>" target="_blank">View</a>
                        </div>
                        
                        <div class="form-group">
                            <label for="proposal_status">Title Status:</label>
                            <select id="proposal_status" name="proposal_status" required>
                                <option value="pending" <?php echo ($row["proposal_status"] == "pending" ? "selected" : ""); ?>>Pending</option>
                                <option value="reject" <?php echo ($row["proposal_status"] == "reject" ? "selected" : ""); ?>>Reject</option>
                                <option value="approve" <?php echo ($row["proposal_status"] == "approve" ? "selected" : ""); ?>>Approve</option>
                            </select>
                        </div>
                <?php
                    } else {
                        echo "<p>No FYP information found.</p>";
                    }
                    echo '</div>';
                }
                ?>
               
                <!-- Supervisor Render -->
                <?php
                    if($_GET['role'] == 'supervisor') {
                        $sql = "SELECT s.student_ID, u.user_name FROM user u
                        JOIN student s ON u.user_ID = s.user_ID
                        JOIN proposal p ON s.student_ID = p.student_ID
                        WHERE p.supervisor_ID = '" . $_GET["id"] . "' AND p.proposal_status = 'approve' ";

                        $result = $conn->query($sql);
                        $rowcount = mysqli_num_rows($result);

                        echo '<div class="form-section">
                            <h3>Supervised Student</h3>
                            <ul class="supervised_list">';
                        if($rowcount >= 1) {
                            while($row = $result->fetch_assoc()){
                                echo '<li>'.$row['student_ID'].' - '.$row['user_name'].'</li>';
                            }
                        }
                        else {
                            echo "<li>No student is under your supervision currently</li>";
                        }
                        echo '</ul>
                        </div>';
                        
                    }
                ?>
                <div class="form-group">
                    <button type="submit" name="update">Update</button>
                </div>
            </form>
        </div>
    </div>

    <?php
        include "template/footer.php";
    ?> 
</body>

</html>