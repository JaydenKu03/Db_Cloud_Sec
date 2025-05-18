<?php
    require("session.php");
    require ('db_connect.php');

    $conn = openCon();

    if(isset($_POST['update'])) {

        // Genral user information update
        $ID = $_GET['id'];
        $role = $_GET['role'];

        if ($role == 'admin') {
            $sql_get_user_ID = "SELECT user_ID FROM admin WHERE admin_ID = '$ID'";
        }
        elseif ($role == 'supervisor') {
            $sql_get_user_ID = "SELECT user_ID FROM supervisor WHERE supervisor_ID = '$ID'";
        }
        elseif ($role == 'student') {
            $sql_get_user_ID = "SELECT user_ID FROM student WHERE student_ID = '$ID'";
        }  
        else {
            echo "Invalid role provided.";
            exit;
        }

        $result = $conn->query($sql_get_user_ID);
        $row = $result->fetch_assoc();
        $user_ID = $row['user_ID'];

        // Update user table
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];
        $user_email = $_POST['user_email'];
        $user_phone = $_POST['user_phone'];
        $user_role = $_POST['user_role'];

        $sql_update_user = "UPDATE user 
                        SET user_name = '$user_name', user_password = '$user_password', 
                            user_email = '$user_email', user_phone = '$user_phone', 
                            user_role = '$user_role' 
                        WHERE user_ID = '$user_ID'";
                    
        if (!$conn->query($sql_update_user)) {
            echo "Error updating user: " . $conn->error;
        }

        // Student Proposal information update
        if($_GET['role'] == 'student') {
           
            // before update anything, check the supervisor id exist or not:
            $supervisor_ID = $_POST['supervisor_ID'];
            $sql = "SELECT * FROM supervisor WHERE supervisor_ID = '$supervisor_ID'";
            $result = $conn->query($sql);
            if($result->num_rows == 0) {
                echo "<script>alert('No existing supervisor ID');
                    window.location.href = '../user_list.php';</script>;
                </script>";
                exit();
            }

            // Update student table
            $specialization = $_POST['specialization'];

            $sql_update_student = "UPDATE student 
                            SET specialization = '$specialization' 
                            WHERE user_ID = '$user_ID'";

            if (!$conn->query($sql_update_student)) {
                echo "Error updating student: " . $conn->error;
            }

            // Update proposal table
            $project_title = $_POST['project_title'];
            $supervisor_name = $_POST['supervisor_name'];
            $supervisor_ID = $_POST['supervisor_ID'];
            $co_supervisor_name = $_POST['co_supervisor_name'];
            $proposed_by = $_POST['proposed_by'];
            $project_type = $_POST['project_type'];
            $project_specialization = $_POST['project_specialization'];
            $project_category = $_POST['project_category'];
            $industry_collaboration = $_POST['industry_collaboration'];
            $proposal_status = $_POST['proposal_status']; // can be 'approve', 'pending', or 'reject'

            $sql_update_proposal = "UPDATE proposal 
                                SET project_title = '$project_title', 
                                    supervisor_name = '$supervisor_name', supervisor_ID = '$supervisor_ID', 
                                    co_supervisor_name = '$co_supervisor_name', proposed_by = '$proposed_by',
                                    project_type = '$project_type', project_specialization = '$project_specialization',
                                    project_category = '$project_category', industry_collaboration = '$industry_collaboration',
                                    proposal_status = '$proposal_status' 
                                WHERE student_ID = '$ID'";
                                
            if (!$conn->query($sql_update_proposal)) {
                echo "Error updating proposal: " . $conn->error;
            }
        }

        echo "<script>alert('Updated Successfully');
                window.location.href='../view_profile.php?id=" . $_GET['id'] . "&name=" . $user_name . "&role=" . $_GET['role'] . "'
            </script>";
    }
?>