<?php
    require("function/session.php");
    require ('function/check_role.php');

    restrict_admin(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin and Supervisor Registration</title>
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/registration.css">
    <link rel="stylesheet" href="static/reusable.css">
</head>

<body>
    <?php
        include "template/navbar.php";
    ?>

    <div class="container">
        <h1 class="title-font">Admin and Supervisor Registration</h1>
        <form action="function/insert_registration.php" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="John Smith" required />

            <label for="email">Password</label>
            <input type="password" id="password" name="password" required />

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required />

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="012-3456789" required />

            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="supervisor">Supervisor</option>
                <option value="admin">Admin</option>
            </select>

            <div class="button-container">
                <button type="submit" name="submit"class="modern-button">Register</button>
                <button type="reset" class="modern-button">Reset</button>
            </div>
        </form>
    </div>

    <?php
        include "template/footer.php";
    ?>  

</body>

</html>