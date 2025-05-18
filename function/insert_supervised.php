<?php
$conn = OpenCon();

if($_SESSION['user_role'] != "supervisor") {
    die("You Don't Have Access To This Page");
}

$supervisor_ID = $_SESSION["user_ID"];

// Fetch total students supervised
$query1 = "SELECT COUNT(*) AS total_students 
           FROM proposal 
           WHERE supervisor_ID = $supervisor_ID AND proposal_status = 'approve'";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($result1);

if (!$result1) {
    die("Error retrieving total students: " . mysqli_error($conn));
}

// Fetch student details along with assessment grade
$query2 = "SELECT p.student_ID, p.student_name, p.project_title, 
                  COALESCE(a.Grade, 'Pending') AS final_grade,
                  COALESCE(a.assessment_file, 'No File') AS assessment_file
           FROM proposal p
           LEFT JOIN assessment a ON p.student_ID = a.student_ID
           WHERE p.supervisor_ID = $supervisor_ID AND p.proposal_status = 'approve'";

$result2 = mysqli_query($conn, $query2);

if (!$result2) {
    die("Error retrieving student details: " . mysqli_error($conn));
}
?>