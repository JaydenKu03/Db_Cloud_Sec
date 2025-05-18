<?php
require_once 'session.php';
require_once 'db_connect.php';

$conn = OpenCon();

function manageProgress() {
    global $conn;

    // Check if the supervisor is logged in
    if (!isset($_SESSION['user_ID'])) {
        echo "Supervisor not logged in.";
        return;
    }

    $supervisor_id = $_SESSION['user_ID'];
    $student_ID = isset($_GET['student_ID']) ? $_GET['student_ID'] : (isset($_POST['student_ID']) ? $_POST['student_ID'] : '');

    // Handle the viewing of a student's progress
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($student_ID)) {
        // Fetch the student name
        $supervisorQuery = "SELECT student_name FROM proposal WHERE supervisor_ID = '$supervisor_id' AND student_ID = '$student_ID' AND proposal_status = 'approve' LIMIT 1";
        $result = $conn->query($supervisorQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $student_name = $row['student_name'];
            echo "<h2>Supervised Student Name: $student_name</h2>";

            // Fetch progress records for the selected student
            $sql = "SELECT * FROM goal_and_progress WHERE student_ID = '$student_ID'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table id='tracker'>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Progress</th>
                                <th>Next Goal</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    $date = $row['progress_date'];
                    $current = $row['current_progress'];
                    $next = $row['next_goal'];
                    $comment = $row['comment'];

                    echo "<tr>
                            <td>".$date."</td>
                            <td>".$current."</td>
                            <td>".$next."</td>
                            <td>".$comment."</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No progress records found for this student.</p>";
            }

            // Display the comment form
            echo "<h3>Update Progress</h3>
                <form action='' method='POST'>
                    <input type='hidden' name='student_ID' value='$student_ID'>
                    <label for='update-date'>Select Progress Date:</label>
                    <input type='date' id='update-date' name='update-date' required>
                    <label for='update-comment'>Comment:</label>
                    <textarea id='update-comment' name='update-comment' rows='4' required></textarea>
                    <button type='submit'>Submit Comment</button>
                </form>";
        } else {
            echo "<p>No student found for the given ID.</p>";
        }
    }

    // Handle the form submission for updating progress
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($student_ID)) {
        $date = $_POST['update-date'];
        $comment = $_POST['update-comment'];

        // Check if the date exists for this student
        $checkDateSql = "SELECT * FROM goal_and_progress WHERE progress_date = '$date' AND student_ID = '$student_ID'";
        $result = $conn->query($checkDateSql);

        if ($result->num_rows > 0) {
            // Update the comment for the specific date and student
            $updateSql = "UPDATE goal_and_progress SET comment = '$comment' WHERE progress_date = '$date' AND student_ID = '$student_ID'";

            if ($conn->query($updateSql)) {
                echo "<script>
                        alert('Updated Comment!');
                        window.location.href = 'goals_sv.php?student_ID=$student_ID';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Error: Could not update the comment.');
                        window.location.href = 'goals_sv.php?student_ID=$student_ID';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Error: Date not available');
                    window.location.href = 'goals_sv.php?student_ID=$student_ID';
                  </script>";
        }
    }
}
?>
