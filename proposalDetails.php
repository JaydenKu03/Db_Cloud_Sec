<?php
    require("function/session.php");
    require ('function/db_connect.php');
    require ('function/check_role.php');

    restrict_admin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Details</title>
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/reusable.css">
    <link rel="stylesheet" href="static/proposal.css">
</head>
<body>
    <?php
    include "template/navbar.php";
    ?>

    <div class="container">
        <h2 class="title">Proposal Details</h2>

        <?php
        $conn = OpenCon();

        if (isset($_GET['id'])) {
            $proposal_id = $_GET['id'];

            // Fetch proposal details
            $sql = "SELECT * FROM proposal WHERE proposal_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $proposal_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                echo "<div class='details'>";
                echo "<p><strong>Student ID:</strong> {$row['student_ID']}</p>";
                echo "<p><strong>Student Name:</strong> {$row['student_name']}</p>";
                echo "<p><strong>Project Title:</strong> {$row['project_title']}</p>";
                echo "<p><strong>Specialization:</strong> {$row['specialization']}</p>";
                echo "<p><strong>Proposed By:</strong> {$row['proposed_by']}</p>";
                echo "<p><strong>Supervisor Name:</strong> {$row['supervisor_name']}</p>";
                echo "<p><strong>Co-Supervisor Name:</strong> {$row['co_supervisor_name']}</p>";
                echo "<p><strong>Project Type:</strong> {$row['project_type']}</p>";
                echo "<p><strong>Project Category:</strong> {$row['project_category']}</p>";
                echo "<p><strong>Industry Collaboration:</strong> {$row['industry_collaboration']}</p>";
                echo "<p><strong>Proposal Link:</strong> <a href='{$row['file_address']}' target='_blank'>View</a></p>";
                echo "<p><strong>Proposal Status:</strong> <span class='status {$row['proposal_status']}'>{$row['proposal_status']}</span></p>";
                echo "</div>";

                // Approve and Reject buttons
                echo "<form method='post' action=''>
                        <input type='hidden' name='proposal_id' value='{$row['proposal_ID']}'>
                        <button type='submit' name='action' value='approve' class='btn approve-btn'>Approve</button>
                        <button type='submit' name='action' value='reject' class='btn reject-btn'>Reject</button>
                      </form>";
            } else {
                echo "<p>No proposal found with the given ID.</p>";
            }

            $stmt->close();
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $proposal_id = $_POST['proposal_id'];
            $action = $_POST['action'];

            // Update proposal status
            $sql = "UPDATE proposal SET proposal_status = ? WHERE proposal_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $action, $proposal_id);

            if ($stmt->execute()) {
                echo "<p>Proposal status updated successfully.</p>";
            } else {
                echo "<p>Error updating proposal status: " . $conn->error . "</p>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
    
    <?php
        include "template/footer.php";
    ?> 
</body>

</html>
