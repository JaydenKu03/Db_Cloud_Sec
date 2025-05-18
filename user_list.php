<?php
    require ("function/session.php");
    require ('function/db_connect.php');
    require ('function/check_role.php');

    restrict_admin();

    $conn = openCon();

    $sql = "SELECT 
        COALESCE(stu.student_ID, sup.supervisor_ID, a.admin_ID) AS ID,
        u.user_name,
        u.user_email,
        u.user_phone,
        u.user_role,
        IFNULL(stu.specialization, '-') AS specialization
    FROM user u
    LEFT JOIN student stu ON stu.user_ID = u.user_ID
    LEFT JOIN supervisor sup ON sup.user_ID = u.user_ID
    LEFT JOIN admin a ON a.user_ID = u.user_ID";

    if(isset($_POST['filter'])) {
        $user_name = $_POST['user_name'];
        $user_role = $_POST['user_role'];
        $specialization = $_POST['specialization'];
        $conditions = [];
        
        if (!empty($user_name)) {
            $conditions[] = "u.user_name LIKE '%$user_name%'";
        }
        if ($user_role !== "All" && !empty($user_role)) {
            if ($user_role == "Student") {
                $conditions[] = "u.user_role = 'student'";
            } elseif ($user_role == "Supervisor") {
                $conditions[] = "u.user_role = 'supervisor'";
            } elseif ($user_role == "Admin") {
                $conditions[] = "u.user_role = 'admin'";
            }
        }
        if ($specialization !== "All Specializations" && $user_role !== "supervisor") {
            $conditions[] = "stu.specialization = '$specialization'";
        }

        // Add the WHERE clause if there are conditions
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
    }
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/base.css">
    <link rel="stylesheet" href="static/reusable.css">
    <link rel="stylesheet" href="static/table.css">
    <title>Student List</title>
</head>

<body>
    <?php
        include "template/navbar.php";
    ?>

    <main>
        <div class="content-container">

            <div class="filter-container">
                <form action="user_list.php" method="POST">
                    <h2>Filters: </h2>
                    <label for="user_name">User Name:</label>
                    <input type="text" id="user_name" name="user_name" placeholder="Name...">
                    <label for="role">User Role:</label>
                    <select id="role" name="user_role">
                        <option name="all">All Users</option>
                        <option name="student">Student</option>
                        <option name="supervisor">Supervisor</option>
                        <option name="admin">Admin</option>
                    </select>
                    <label for="speacilization">Specialization:</label>
                    <select id="speacilization" name="specialization">
                        <option name="All Specializations">All Specializations</option>
                        <option name="Computer Science">Computer Science</option>
                        <option name="Cybersecurity">Cybersecurity</option>
                        <option name="Game Development">Game Development</option>
                        <option name="Data Science">Data Science</option>
                        <option name="Software Engineering">Software Engineering</option>
                        <option name="Information System">Information System</option>
                    </select>
                    <input type="submit" name="filter" value="Search">
                </form>
            </div>

            <div id="studList-table-container" class="table-container activeTable">
                <h1>User List</h1>
                <table id="student-list-table" class="modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>User Phone</th>
                            <th>User Specialization</th>
                            <th>User Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(mysqli_num_rows($result) >= 1) {
                                $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr onclick=\"window.location.href='view_profile.php?id=".$row['ID']."&name=".$row['user_name']."&role=".$row['user_role']."'\" style=\"cursor:pointer;\">
                                            <td>$count</td>
                                            <td>".$row['ID']."</td>
                                            <td>".$row['user_name']."</td>
                                            <td>".$row['user_email']."</td>
                                            <td>".$row['user_phone']."</td>
                                            <td>".$row['specialization']."</td>
                                            <td>".$row['user_role']."</td>
                                        </tr>";    
                                    $count+=1;
                                }
                            }
                            else {
                                echo "<td colspan=7 style='text-align: center;'>No Results Available</td>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>   
        </div>
    </main>

    <?php
        include "template/footer.php";
    ?>  
</body>
</html>