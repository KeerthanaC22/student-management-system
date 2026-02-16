<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM subjects");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subjects</title>
    <link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Subjects</h2>
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

<a href="add.php">
  <i class="fa-solid fa-book-open"></i>
  Add Subject
</a>

<a href="list.php" class="active">
  <i class="fa-solid fa-book"></i>
  View Subjects
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
        <a href="add.php">Add Subject</a>
        <a href="list.php" class="active">View Subjects</a>
        <a href="../marks/add.php">Add Marks</a>
        <a href="../subject/add.php">Add Subject</a>
        <a href="../subject/list.php">View Subjects</a>
        <a href="../auth/logout.php" class="logout">Logout</a> -->
    </div>

    <div class="main-content">
        <div class="card">
            <h3>Subjects List</h3>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Subject Name</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['subject_id'] ?></td>
                    <td><?= $row['subject_name'] ?></td>
                </tr>
                <?php } ?>
            </table>
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
