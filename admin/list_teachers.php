<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT username, email FROM users WHERE role='teacher'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teachers List</title>
    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Teachers List</h2>
</div>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">✖</span>

        <h2>Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_teacher.php">Add Teacher</a>
        <a href="list_teachers.php" class="active">View Teachers</a>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="card">
            <h3>Teachers</h3>

            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['email']; ?></td>
                </tr>
                <?php } ?>
            </table>

        </div>

    </div>
</div>

<!-- TOGGLE SIDEBAR SCRIPT -->
<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>

</body>
</html>
