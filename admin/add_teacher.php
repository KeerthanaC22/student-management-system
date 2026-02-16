<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['add_teacher'])) {

    // ✅ FIXED TYPO
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password, role)
              VALUES ('$username', '$email', '$password', 'teacher')";

    if (mysqli_query($conn, $query)) {
        $success = "Teacher added successfully!";
    } else {
        $error = "Error adding teacher (username may already exist)";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>

    <!-- ✅ USE SAME DASHBOARD CSS -->
    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Add Teacher</h2>
</div>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">✖</span>

        <h2>Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_teacher.php" class="active">Add Teacher</a>
        <a href="list_teachers.php">View Teachers</a>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="card">
            <h3>Add Teacher</h3>

            <?php if (isset($success)) { ?>
                <div class="notification">
                    ✅ <?= $success ?>
                </div>
            <?php } ?>

            <?php if (isset($error)) { ?>
                <div class="notification empty">
                    ❌ <?= $error ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="form-group">
                    <label>Teacher Username</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" name="add_teacher" class="btn">
                    Add Teacher
                </button>

            </form>
        </div>

    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>

</body>
</html>
