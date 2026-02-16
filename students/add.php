<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $roll  = $_POST['roll'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    mysqli_query($conn,
        "INSERT INTO students (roll_number, first_name, last_name, email, phone)
         VALUES ('$roll','$fname','$lname','$email','$phone')"

    );
    mysqli_query($conn,
        "INSERT INTO users (roll_number, first_name, last_name, email, phone)
         VALUES ('$roll','$fname','$lname','$email','$phone')"

    );
    

    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>

    <!-- ✅ CORRECT CSS -->
     <link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Add Student</h2>
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

<a href="add.php" class="active">
  <i class="fa-solid fa-user-plus"></i>
  Add Student
</a>

<a href="list.php">
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
        <a href="add.php" class="active">➕ Add Student</a>
        <a href="list.php">📋 View Students</a>
        <a href="../marks/add.php">📝 Add Marks</a>
        <a href="../subject/add.php">📚 Add Subject</a>
        <a href="../subject/list.php">📖 View Subjects</a>
        <a href="../auth/logout.php" class="logout">🚪 Logout</a> -->
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="card">
            <h3 ><center>Add Student</center></h3>

            <form method="POST">

                <div class="form-group">
                    <label>Roll Number</label>
                    <input type="text" name="roll" required>
                </div>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="fname" required>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone">
                </div>

                <!-- ✅ IMPORTANT: name="submit" -->
                <button type="submit" name="submit" class="btn">
                    Add Student
                </button>

            </form>
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
