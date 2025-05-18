<?php
require_once 'db_connect.php';
$conn = OpenCon();

if (isset($_POST['submit'])) {
    if (empty($_POST['Supervisor_ID']) || empty($_POST['Student_ID'])) {
        echo "Please fill in all fields.";
    } else {

        //Validation for Student ID
        $sql = 'SELECT * FROM student WHERE student_ID = '.$_POST['Student_ID'].'';
        $result = $conn->query($sql);
        if($result->num_rows == 0) {
            echo "<script>alert('No existing student ID');
                   window.location.href = '../assessment.php' ;
            </script>";
            exit();
        }

        $AssDate = $conn->real_escape_string($_POST['AssDate']);
        $Program_name = $conn->real_escape_string($_POST['Program_name']);

        // Handle assessment file
        $target_Ass_Dir = __DIR__ . '/../store_assessment/'; 
        $assessment_file = basename($_FILES["assessment_file"]["name"]);
        $targetPathAss = $target_Ass_Dir . $assessment_file;

        // Handle signature file
        $target_Sign_Dir = __DIR__ . '/../store_signature/'; 
        $signature_file = basename($_FILES["signature_file"]["name"]);
        $targetPathSign = $target_Sign_Dir . $signature_file;

        $Supervisor_ID = $conn->real_escape_string($_POST['Supervisor_ID']);
        $Student_ID = $conn->real_escape_string($_POST['Student_ID']);
        $Clarity = $conn->real_escape_string($_POST['Clarity']);
        $Understanding = $conn->real_escape_string($_POST['Understanding']);
        $Methodology = $conn->real_escape_string($_POST['Methodology']);
        $Implementation = $conn->real_escape_string($_POST['Implementation']);
        $Innovation = $conn->real_escape_string($_POST['Innovation']);
        $Report_Quality = $conn->real_escape_string($_POST['Report_Quality']);
        $Presentation_Skills = $conn->real_escape_string($_POST['Presentation_Skills']);
        $Answering_Ability = $conn->real_escape_string($_POST['Answering_Ability']);
        
        $Total_mark = $Clarity + $Understanding + $Methodology + $Implementation + $Innovation + $Report_Quality + $Presentation_Skills + $Answering_Ability;
        $Grade_cal = ($Total_mark / 80) * 100; // Convert to percentage
        if ($Grade_cal >= 90) {
            $Final_Grade = 'A+';
        } elseif ($Grade_cal >= 80) {
            $Final_Grade = 'A';
        } elseif ($Grade_cal >= 70) {
            $Final_Grade = 'A-';
        } elseif ($Grade_cal >= 65) {
            $Final_Grade = 'B+';
        } elseif ($Grade_cal >= 60) {
            $Final_Grade = 'B';
        } elseif ($Grade_cal >= 55) {
            $Final_Grade = 'C+';
        } elseif ($Grade_cal >= 50) {
            $Final_Grade = 'C';
        } else {
            $Final_Grade = 'F'; // Failing grade
        }

        // Move uploaded files
        if (is_uploaded_file($_FILES["assessment_file"]["tmp_name"])) {
            move_uploaded_file($_FILES["assessment_file"]["tmp_name"], $targetPathAss);
        } else {
            echo "<script>alert('Error uploading assessment file');
                    window.location.href = '../assessment.php';
            </script>";
            exit();
        }

        if (is_uploaded_file($_FILES["signature_file"]["tmp_name"])) {
            move_uploaded_file($_FILES["signature_file"]["tmp_name"], $targetPathSign);
        } else {
            echo "<script>alert('Error uploading signature file.');
                    window.location.href = '../assessment.php';
            </script>";
            exit();
        }

        // Insert into database
        $sql = "INSERT INTO assessment (
            assessment_date, 
            program_name, 
            assessment_file, 
            supervisor_ID, 
            student_ID, 
            clarity_objectives, 
            understanding_problem, 
            quality_methodology, 
            technical_implementation, 
            innovation, 
            quality_report, 
            presentation_skills, 
            ability_answer_question, 
            signature_file,
            Grade

        ) VALUES (
            '$AssDate', 
            '$Program_name', 
            '$assessment_file', 
            '$Supervisor_ID', 
            '$Student_ID', 
            '$Clarity', 
            '$Understanding', 
            '$Methodology', 
            '$Implementation', 
            '$Innovation', 
            '$Report_Quality', 
            '$Presentation_Skills', 
            '$Answering_Ability', 
            '$signature_file',
            '$Final_Grade'
        )";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Assessment has been uploaded.');
                    window.location.href = '../assessment.php';
            </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    header("Location: assessment.php");
}
CloseCon($conn);
?>
