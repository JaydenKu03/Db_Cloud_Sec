<?php
    require ('function/session.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Submission</title>
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/registration.css">
    <link rel="stylesheet" href="static/reusable.css">
</head>

<body>
    <?php
        include "template/navbar.php";
    ?>

    <div class="container">
        <h1 class="title-font">Proposal Submission</h1>
        <form action="function/proposalSub.php" method="POST" enctype="multipart/form-data">
            <label for="name">Student Name</label>
            <input type="text" id="name" name="name" 
            <?php 
                if ($_SESSION['user_role'] == 'student') {
                    echo 'value="' . $_SESSION['user_name'] . '" readonly';
                }
            ?> 
            required />

            <label for="id">Student ID</label>
            <input type="text" id="id" name="id"
            <?php 
                if ($_SESSION['user_role'] == 'student') {
                    echo 'value="' . $_SESSION['user_ID'] . '" readonly';
                }
            ?> 
            required />

            <label for="specialization">Specialization</label>
            <select name="speacilization" id="specialization" required>
                <option value="Computer Science">Computer Science</option>
                <option value="Cybersecurity">Cybersecurity</option>
                <option value="Game Development">Game Development</option>
                <option value="Data Science">Data Science</option>
                <option value="Software Engineering">Software Engineering</option>
                <option value="Information System">Information System</option>
            </select>

            <label for="title">Project Title</label>
            <input type="text" id="title" name="title" required />

            <label for="supervisor">Supervisor Name</label>
            <input type="text" id="supervisor" name="supervisor" 
            <?php 
                if ($_SESSION['user_role'] == 'supervisor') {
                    echo 'value="' . $_SESSION['user_name'] . '" readonly';
                }
            ?> 
            required />

            <label for="supervisor_id">Supervisor ID</label>
            <input type="text" id="supervisor_id" name="supervisor_id"
            <?php 
                if ($_SESSION['user_role'] == 'supervisor') {
                    echo 'value="' . $_SESSION['user_ID'] . '" readonly';
                }
            ?> 
            required />

            <label for="cosupervisor">Co-Supervisor Name</label>
            <input type="text" id="cosupervisor" name="cosupervisor" />

            <label for="status">Proposed By:</label>
            <select id="status" name="status" required>
                <option value="Student">Student-proposed</option>
                <option value="Lecture">Lecture-proposed</option>
                <option value="Industry">Industry-proposed</option>
            </select>

            <label for="type">Project Type</label>
            <select name="type" id="type" required>
                <option value="Application">Application-based</option>
                <option value="Research">Research-based</option>
                <option value="Application and Research">Application and Reseach-based</option>
            </select>

            <label for="project_specialization">Project Specialization</label>
            <select name="project_speacilization" id="project_specialization" required>
                <option value="Computer Science">Computer Science</option>
                <option value="Cybersecurity">Cybersecurity</option>
                <option value="Game Development">Game Development</option>
                <option value="Data Science">Data Science</option>
                <option value="Software Engineering">Software Engineering</option>
                <option value="Information System">Information System</option>
            </select>

            <label for="category">Project Category</label>
            <select name="category" id="category" required>
                <option value="Critical System">Critical System</option>
                <option value="Application Software">Application Software</option>
                <option value="Software Tools & Utilities">Software Tools & Utilities</option>
                <option value="Service Oriented Computing">Service Oriented Computing</option>
                <option value="Data Engineering">Data Engineering</option>
                <option value="Data Analytics">Data Analytics</option>
                <option value="Cryptography and Data Security">Cryptography and Data Security</option>
                <option value="Investigation and Analysis">Investigation and Analysis</option>
                <option value="Security and Defence">Security and Defence</option>
                <option value="Game Software Development (GSD)">Game Software Development (GSD)</option>
                <option value="Game Algorithm Research (GAR)">Game Algorithm Research (GAR)</option>
                <option value="Game Design Prototyping (GDP)">Game Design Prototyping (GDP)</option>
                <option value="IT Infrastructure">IT Infrastructure</option>
                <option value="Transaction Processing Systems">Transaction Processing Systems</option>
                <option value="Intelligent Systems">Intelligent Systems</option>
            </select>

            <label for="industry">Industry Collaboration</label>
            <select id="industry" name="industry">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>

            <label for="Proposal">Proposal Document</label>
            <input type="file" id="Proposal" name="Proposal" required />

            <div class="button-container">
                <button type="submit" class="modern-button">Submit</button>
                <button type="reset" class="modern-button">Reset</button>
            </div>
        </form>
    </div>

    <?php
        include "template/footer.php";
    ?>

</body>

</html>