<?php
    require ('function/session.php');
    require ('function/db_connect.php');

    $conn = OpenCon();

    $user_ID = isset($_GET['id']) ? $_GET['id'] : '';
    $role = isset($_GET['role']) ? $_GET['role'] : '';
    
    if(empty($user_ID) || empty($role)) {
        echo "<script>alert('Invalid parameters'); window.location.href='index.php';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="static/profile_details.css">
</head>

<body>
    <div class="profile-container">
        <h1>Update Profile</h1>
        
        <form action="function/update_profile.php?id=<?php echo htmlspecialchars($user_ID); ?>&role=<?php echo htmlspecialchars($role); ?>" method="post">
            <?php
                if($role == "admin") {
                    $sql = "SELECT a.admin_ID, u.user_name, u.user_password, u.user_email, u.user_phone, u.user_role FROM [user] u
                            JOIN admin a ON u.user_ID = a.user_ID
                            WHERE a.admin_ID = ?";
                }
                else if($role == "supervisor") {
                    $sql = "SELECT s.supervisor_ID, u.user_name, u.user_password, u.user_email, u.user_phone FROM [user] u
                            JOIN supervisor s ON u.user_ID = s.user_ID
                            WHERE s.supervisor_ID = ?";
                }
                else if($role == "student"){
                    $sql = "SELECT s.student_ID, s.specialization, u.user_name, u.user_password, u.user_email, u.user_phone FROM [user] u
                            JOIN student s ON u.user_ID = s.user_ID
                            WHERE s.student_ID = ?";
                }
            
                $params = array($user_ID);
                $stmt = sqlsrv_query($conn, $sql, $params);
                
                if($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                
                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                
                if(!$row) {
                    echo "<script>alert('Information retrieve error'); window.location.href='index.php';</script>";
                    exit;
                }
            ?>

            <div class="form-group">
                <label for="user_id">ID:</label>
                <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($row[$role.'_ID']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="user_name">Name:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($row['user_name']); ?>" required readonly>
            </div>

            <div class="form-group">
                <label for="user_email">Email:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo htmlspecialchars($row['user_email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="user_phone">Phone:</label>
                <input type="tel" id="user_phone" name="user_phone" value="<?php echo htmlspecialchars($row['user_phone']); ?>">
            </div>

            <?php if($role == "student"): ?>
                <div class="form-group">
                    <label for="specialization">Specialization:</label>
                    <input type="text" id="specialization" name="specialization" value="<?php echo htmlspecialchars($row['specialization']); ?>" readonly>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="new_password">New Password (leave blank to keep current):</label>
                <input type="password" id="new_password" name="new_password">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-update">Update Profile</button>
                <a href="profile.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>