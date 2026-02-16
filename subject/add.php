<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $subject = $_POST['subject_name'];

    mysqli_query($conn,
        "INSERT INTO subjects (subject_name) VALUES ('$subject')"
    );

    $success = "Subject added successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
    <link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Add Subject</h2>
</div>

<div class="dashboard-wrapper">

    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">✖</span>
<div id="dbheading">
        <h2 >Teacher</h2>
        </div>
        <a href="../dashboard.php">
  <i class="fa-solid fa-house"></i>
  Dashboard
</a>

<a href="../students/add.php" class="active">
  <i class="fa-solid fa-user-plus"></i>
  Add Student
</a>

<a href="../students/list.php">
  <i class="fa-solid fa-users"></i>
  View Students
</a>

<a href="../marks/add.php">
  <i class="fa-solid fa-pen-to-square"></i>
  Add Marks
</a>

<a href="../subject/add.php">
  <i class="fa-solid fa-book-open"></i>
  Add Subject
</a>

<a href="../subject/list.php">
  <i class="fa-solid fa-book"></i>
  View Subjects
</a>

<a href="../auth/logout.php" class="logout">
  <i class="fa-solid fa-right-from-bracket"></i>
  Logout
</a>

        <!-- <a href="../dashboard.php">Dashboard</a>
        <a href="../students/add.php" class="active">Add Student</a>
        <a href="../students/list.php">View Students</a>
        <a href="../marks/add.php"> Add Marks</a>
        <a href="../subject/add.php">Add Subject</a>
        <a href="../subject/list.php">View Subjects</a>
        <a href="../auth/logout.php" class="logout">🚪 Logout</a> -->
    </div>

    <div class="main-content">
        <div class="card">
            <h3>Add Course / Subject</h3>

            <?php if (isset($success)) { ?>
                <div class="notification">✅ <?= $success ?></div>
            <?php } ?>

            <form method="POST">
                <div class="form-group">
                    <label>Subject Name</label>
                    <input type="text" name="subject_name" required>
                </div>

                <button type="submit" name="submit" class="btn">
                    Add Subject
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
