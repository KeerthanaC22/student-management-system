<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}

/* Fetch students */
$students = mysqli_query(
    $conn,
    "SELECT student_id, roll_number, first_name FROM students"
);

/* Fetch subjects (ID + NAME already exists) */
$subjects = mysqli_query(
    $conn,
    "SELECT subject_id, subject_name FROM subjects"
);

/* Insert marks */
if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $marks      = $_POST['marks'];

    mysqli_query($conn,
        "INSERT INTO marks (student_id, subject_id, marks)
         VALUES ('$student_id', '$subject_id', '$marks')"
    );

    $success = "Marks added successfully";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Marks</title>
    <link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Add Marks</h2>
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

<a href="../students/add.php">
  <i class="fa-solid fa-user-plus"></i>
  Add Student
</a>

<a href="../students/list.php">
  <i class="fa-solid fa-users"></i>
  View Students
</a>

<a href="add.php" class="active">
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
        <a href="../students/add.php">Add Student</a>
        <a href="../students/list.php">View Students</a>
        <a href="add.php" class="active">Add Marks</a>
        <a href="../subject/add.php">Add Subject</a>
        <a href="../subject/list.php">View Subjects</a>
        <a href="../auth/logout.php" class="logout">Logout</a> -->
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="card">
            <h3>Add Marks</h3>

            <!-- Success Message -->
            <?php if (isset($success)) { ?>
                <div class="notification">
                    ✅ <?= $success ?>
                </div>
            <?php } ?>

            <form method="POST">

                <!-- Student -->
                <div class="form-group">
                    <label>Student</label>
                    <select name="student_id" required>
                        <option value="">Select Student</option>
                        <?php while ($s = mysqli_fetch_assoc($students)) { ?>
                            <option value="<?= $s['student_id'] ?>">
                                <?= $s['roll_number'] ?> - <?= $s['first_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label>Subject</label>
                    <select name="subject_id" required>
                        <option value="">Select Subject</option>
                        <?php while ($sub = mysqli_fetch_assoc($subjects)) { ?>
                            <option value="<?= $sub['subject_id'] ?>">
                                <?= $sub['subject_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Marks -->
                <div class="form-group">
                    <label>Marks</label>
                    <input type="number" name="marks" min="0" max="100" required>
                </div>

                <button type="submit" name="submit" class="btn">
                    Submit Marks
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
