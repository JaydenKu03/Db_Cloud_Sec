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
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/announcement.css">
    <title>Annoucement and Event</title>
</head>

<body>
    <?php
        include "template/navbar.php";
    ?>
    
    <div class="form-container">
        <div class="tabs">
            <div class="active-tab tab" id="announcement-tab">Announcement</div>
            <div class="tab" id="event-tab">Event</div>
        </div>

        <form action="function/post_content.php" method="POST" id="announcement-form" class="active-form">
            <label for="announcement_title">Announcement Title:</label>
            <input type="text" id="announcement_title" name="announcement_title" maxlength="40" placeholder="Enter Title">

            <label for="announcement_content">Announcement Content:</label>
            <textarea id="announcement_content" name="announcement_content" maxlength="350" rows="4" placeholder="Write your announcement..."></textarea>

            <button type="submit" name="submit_announcement">Post Announcement</button>
        </form>

        <form action="function/post_content.php" method="POST" id="event-form">
            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date">

            <label for="event_title">Event Title:</label>
            <input type="text" id="event_title" name="event_title" maxlength="40" placeholder="Enter Event Title">

            <button type="submit" name="submit_event">Post Event</button>
        </form>
    </div>

    <?php
        include "template/footer.php";
    ?>    
    <script src = "static/announcement.js"></script>
</body>

</html>