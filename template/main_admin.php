<?php
    if (!defined('MAIN_ADMIN') || MAIN_ADMIN !== true) {
        die('Forbidden: Direct access is not allowed.');
    }
?>

<div class="operation-task">
    <a href="approved_list.php">
        <img src="images/approved.png" alt="approved_list">
        <p>Approved Project</p>
    </a>
</div>
<div class="operation-task">
    <a href="rejected_list.php">
        <img src="images/rejected.png" alt="rejected_list">
        <p>Rejected Project</p>
    </a>
</div>
<div class="operation-task">
    <a href="pending_list.php">
        <img src="images/pending.png" alt="pending_list">
        <p>Pending Project</p>
    </a>
</div>
<div class="operation-task">
    <a href="user_list.php">
        <img src="images/student.png" alt="user_list">
        <p>User List</p>
    </a>
</div>
<div class="operation-task">
    <a href="admin_register.php"><img src="images/register.png" alt="registration">
        <p>Account Registration</p>
    </a>
</div>
<div class="operation-task">
    <a href="announcement.php"><img src="images/announcement.png" alt="registration">
        <p>Announcement & Event</p>
    </a>
</div>

