<?php
require_once 'session.php';
require_once 'db_connect.php';
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $id = $_POST['id'];
    $specialization = $_POST['speacilization'];
    $title = $_POST['title'];
    $supervisor = $_POST['supervisor'];
    $supervisor_id = $_POST['supervisor_id'];
    $cosupervisor = $_POST['cosupervisor'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $project_specialization = $_POST['project_speacilization'];
    $category = $_POST['category'];
    $industry = $_POST['industry'];
    $proposed = 'pending';


    //Validation for student ID and supervisor ID
    if($_SESSION['user_role'] == "student") {
        $sql = "SELECT * FROM supervisor WHERE supervisor_ID = '$supervisor_id'";
        $result = $conn->query($sql);
        if($result->num_rows == 0) {
            echo "<script>alert('No existing supervisor ID');
                   window.location.href = '../proposal_submission.php';</script>;
            </script>";
            exit();
        }
    }
    if($_SESSION['user_role'] == "supervisor") {
        $sql = "SELECT * FROM student WHERE student_ID = '$id'";
        $result = $conn->query($sql);
        if($result->num_rows == 0) {
            echo "<script>alert('No existing student ID');
                    window.location.href = '../proposal_submission.php';
            </script>";
            exit();
        }
    }


    if (isset($_FILES['Proposal']) && $_FILES['Proposal']['error'] == 0) {
        $file_tmp_name = $_FILES['Proposal']['tmp_name'];
        $file_name = $_FILES['Proposal']['name'];
        $file_size = $_FILES['Proposal']['size'];
        $file_type = $_FILES['Proposal']['type'];

        $upload_dir = __DIR__ . '/../store_proposal/';  
        $file_path = $upload_dir . basename($file_name);

        // Check if the file is a PDF (optional validation)
        if ($file_type == "application/pdf") {
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($file_tmp_name, $file_path)) {
                // Insert the data into the database
                $db_file_path = 'store_proposal/' . basename($file_name);
                $sql = "INSERT INTO proposal (student_name, student_ID, specialization, project_title, supervisor_name, supervisor_ID, co_supervisor_name, proposed_by, project_type, project_specialization, project_category, industry_collaboration, file_address, proposal_status) 
                        VALUES ('$name', '$id', '$specialization', '$title', '$supervisor', '$supervisor_id', '$cosupervisor', '$status', '$type', '$project_specialization', '$category', '$industry', '$db_file_path', '$proposed')";

                if ($conn->query($sql)) {
                    echo "<script>alert('Proposal submitted successfully!'); 
                    window.location.href = '../proposal_submission.php';</script>";
                } else {
                    echo "<script>alert('Error: Could not save the proposal to the database.');</script>";
                }
            } else {
                echo "<script>alert('Error: Failed to upload the file.');</script>";
            }
        } else {
            echo "<script>alert('Error: Only PDF files are allowed.');</script>";
        }
    } else {
        echo "<script>alert('Error: No file uploaded or file upload error.');</script>";
    }
}

$conn->close();
?>
