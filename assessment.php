<?php
    require("function/session.php");
    require("function/check_role.php");

    restrict_supervisor();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Submission Page</title>
    <link rel="stylesheet" href="static/Assessment.css">
    <link rel="stylesheet" href="static/reusable.css">
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/table.css">
</head>

<body>
    <?php include "template/navbar.php"; ?>

    <h1 class="title-font"><b>Final Year Project Student Assessment</b></h1>
    <br />
    <div class="container">
        <form name="Assessment" action="function/insert_assessment.php" method="POST" enctype="multipart/form-data">
            <h3>Please fill in the following Assessment</h3>
            <br />
            <div class="form-group">
                <label for="Supervisor_ID">SUPERVISOR ID:</label>
                <br />
                <input type="text" id="Supervisor_ID" name="Supervisor_ID" 
                    <?php echo 'value="'.$_SESSION['user_ID'].'" readonly ';?>
                required>
            </div>
            <br />
            <div class="form-group">
                <label for="Student_Name">SUPERVISED STUDENT NAME:</label>
                <br />
                <input type="text" id="Student_Name" name="Student_Name" required>
            </div>
            <br />
            <div class="form-group">
                <label for="Student_ID">SUPERVISED STUDENT ID:</label>
                <br />
                <input type="text" id="Student_ID" name="Student_ID" required>
            </div>
            <br />
            <div class="form-group">
                <label for="Title">Project Title:</label>
                <br />
                <input type="text" id="Title" name="Title" required>
            </div>
            <br />
            <div class="form-group">
                <label for="AssDate">Assessment Date:</label>
                <br />
                <input type="date" id="AssDate" name="AssDate" required>
            </div>
            <br />
            <div class="form-group">
                <label for="Program_name">Program Name:</label>
                <br />
                <input type="text" id="Program_name" name="Program_name" required>
            </div>
            <br />

            <h3>Evaluation Criteria</h3>
            <br />
            <table id="evaluation">
                <thead>
                    <tr>
                        <th>Criteria</th>
                        <th>Marks</th>
                        <th>Maximum Mark</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Clarity and Objectives</td>
                        <td><input type="number" name="Clarity" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>Understanding of the problem</td>
                        <td><input type="number" name="Understanding" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                </tbody>
            </table>
            <br />

            <h3>Project Execution</h3>
            <br />
            <table id="Execution">
                <thead>
                    <tr>
                        <th>Criteria</th>
                        <th>Marks</th>
                        <th>Maximum Mark</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Quality of methodology</td>
                        <td><input type="number" name="Methodology" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>Technical Implementation</td>
                        <td><input type="number" name="Implementation" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>Innovation</td>
                        <td><input type="number" name="Innovation" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                </tbody>
            </table>
            <br />

            <h3>Presentation</h3>
            <br />
            <table id="presentation">
                <thead>
                    <tr>
                        <th>Criteria</th>
                        <th>Marks</th>
                        <th>Maximum Mark</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Quality of report</td>
                        <td><input type="number" name="Report_Quality" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>Presentation skills</td>
                        <td><input type="number" name="Presentation_Skills" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>Ability to answer questions</td>
                        <td><input type="number" name="Answering_Ability" min="0" max="10" required></td>
                        <td>10</td>
                    </tr>
                </tbody>
            </table>
            <br />

            <h3>Upload Assessment</h3>
            <br />
            <div class="form-group">
                <label for="assessment_file">Assessment File:</label>
                <br />
                <input type="file" id="assessment_file" name="assessment_file" accept=".pdf, .doc, .docx" required>
            </div>
            <br />
            <div class="form-group">
                <label for="signature_file">Supervisor's Signature:</label>
                <br />
                <input type="file" id="signature_file" name="signature_file" accept=".png, .jpg, .jpeg" required>
            </div>
            <br />

            <button type="submit" id="sub" name="submit" value="submit">Submit</button>
        </form>
    </div>
    <br />

    <?php include "template/footer.php"; ?>
</body>

</html>
