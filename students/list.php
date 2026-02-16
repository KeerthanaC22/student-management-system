<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students List</title>
    <!-- ✅ FIXED CSS PATH -->
     <link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Students List</h2>
</div>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
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
  <i class="fa-solid fa-user-plus"></i>
  Add Student
</a>

<a href="list.php" class="active">
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

        <!-- <a href="../dashboard.php">🏠 Dashboard</a>
        <a href="add.php">➕ Add Student</a>
        <a href="list.php" class="active">📋 View Students</a>
        <a href="../marks/add.php">📝 Add Marks</a>
        <a href="../subject/add.php">📚 Add Subject</a>
        <a href="../subject/list.php">📖 View Subjects</a>
        <a href="../auth/logout.php" class="logout">🚪 Logout</a> -->
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="card">
            <h3>Students</h3>

            <table>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['roll_number'] ?></td>
                    <td><?= $row['first_name']." ".$row['last_name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['gender'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['student_id'] ?>" class="btn-sm">
                            Edit
                        </a>
                        <a href="delete.php?id=<?= $row['student_id'] ?>"
                           class="btn-sm danger"
                           onclick="return confirm('Are you sure you want to delete this student?')">
                           Delete
                        </a>
                    </td>
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
