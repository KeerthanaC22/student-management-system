<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

/* Fetch student */
$student = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM students WHERE student_id = $id")
);

if (!$student) {
    echo "Student not found";
    exit();
}

/* Update student */
if (isset($_POST['update'])) {

    $roll   = $_POST['roll'];
    $fname  = $_POST['fname'];
    $lname  = $_POST['lname'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $gender = $_POST['gender'];

    mysqli_query($conn,
        "UPDATE students SET
            roll_number = '$roll',
            first_name  = '$fname',
            last_name   = '$lname',
            email       = '$email',
            phone       = '$phone',
            gender      = '$gender'
         WHERE student_id = $id"
    );

    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Edit Student</h2>
</div>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">✖</span>
<div id="dbheading">
        <h2 >Teacher</h2>
        </div><a href="../dashboard.php">
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
            <h3>Edit Student</h3>

            <form method="POST">

                <div class="form-group">
                    <label>Roll Number</label>
                    <input type="text" name="roll" value="<?= $student['roll_number'] ?>" required>
                </div>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="fname" value="<?= $student['first_name'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" value="<?= $student['last_name'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= $student['email'] ?>">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?= $student['phone'] ?>">
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option <?= $student['gender']=='Male'?'selected':'' ?>>Male</option>
                        <option <?= $student['gender']=='Female'?'selected':'' ?>>Female</option>
                        <option <?= $student['gender']=='Other'?'selected':'' ?>>Other</option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn">
                    Update Student
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
