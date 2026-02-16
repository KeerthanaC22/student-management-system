<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$page = isset($_GET['page']) ? $_GET['page'] : 'notifications';

/* Fetch student profile */
$student = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM students WHERE user_id = $user_id")
);

if (!$student) {
    echo "Student profile not found";
    exit();
}

/* Fetch all marks */
$marks = mysqli_query(
    $conn,
    "SELECT subjects.subject_name, marks.marks
     FROM marks
     JOIN subjects ON marks.subject_id = subjects.subject_id
     WHERE marks.student_id = ".$student['student_id']
);

/* Dashboard statistics */
$stats = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT 
            COUNT(*) AS total_subjects,
            ROUND(AVG(marks),2) AS avg_marks
         FROM marks
         WHERE student_id = ".$student['student_id']
    )
);

/* Recent marks */
$recentMarks = mysqli_query(
    $conn,
    "SELECT subjects.subject_name, marks.marks
     FROM marks
     JOIN subjects ON marks.subject_id = subjects.subject_id
     WHERE marks.student_id = ".$student['student_id']."
     ORDER BY marks.mark_id DESC
     LIMIT 3"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../assects/css/student.css?v=4">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Student Dashboard</h2>
</div>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">✖</span>

        <h2>Student</h2>

        <a href="dashboard.php" class="<?= $page=='notifications'?'active':'' ?>">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>

        <a href="dashboard.php?page=profile" class="<?= $page=='profile'?'active':'' ?>">
            <i class="fa-solid fa-user"></i> Profile
        </a>

        <a href="dashboard.php?page=marks" class="<?= $page=='marks'?'active':'' ?>">
            <i class="fa-solid fa-clipboard-list"></i> Marks
        </a>

        <a href="../auth/logout.php" class="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- ================= DASHBOARD HOME ================= -->
        <?php if ($page == 'notifications') { ?>

        <!-- Welcome -->
        <div class="card">
            <h3>Welcome, <?= $student['first_name']; ?></h3>
            <p>
                Roll Number: <strong><?= $student['roll_number']; ?></strong>
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <h3>My Overview</h3>

            <div style="display:flex; gap:20px; flex-wrap:wrap;">
                <div style="flex:1; min-width:200px; background:#e0f2fe; padding:15px; border-radius:8px;">
                    <h4>Subjects</h4>
                    <p style="font-size:22px; font-weight:bold;">
                        <?= $stats['total_subjects'] ?? 0 ?>
                    </p>
                </div>

                <div style="flex:1; min-width:200px; background:#dcfce7; padding:15px; border-radius:8px;">
                    <h4>Average Marks</h4>
                    <p style="font-size:22px; font-weight:bold;">
                        <?= $stats['avg_marks'] ?? 0 ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Recent Marks -->
        <div class="card">
            <h3>Recent Marks</h3>

            <?php if (mysqli_num_rows($recentMarks) > 0) { ?>
                <table class="marks-table">
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                    <?php while ($r = mysqli_fetch_assoc($recentMarks)) { ?>
                    <tr>
                        <td><?= $r['subject_name']; ?></td>
                        <td><?= $r['marks']; ?></td>
                    </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>No marks available yet.</p>
            <?php } ?>
        </div>

        <!-- Notifications -->
        <div class="card">
            <h3>Notifications</h3>
            <div class="notification">Welcome to the Student Portal</div>
            <div class="notification">Marks will be updated by teachers</div>
            <div class="notification empty">No new notifications</div>
        </div>

        <!-- ================= PROFILE PAGE ================= -->
        <?php } elseif ($page == 'profile') { ?>

        <div class="card">
            <h3>Student Profile</h3>

            <p><strong>Roll Number:</strong> <?= $student['roll_number'] ?></p>
            <p><strong>Name:</strong> <?= $student['first_name']." ".$student['last_name'] ?></p>
            <p><strong>Email:</strong> <?= $student['email'] ?></p>
            <p><strong>Phone:</strong> <?= $student['phone'] ?></p>
            <p><strong>Gender:</strong> <?= $student['gender'] ?></p>
        </div>

       
   


        <!-- ================= MARKS PAGE ================= -->
        <?php } elseif ($page == 'marks') { ?>

        <div class="card">
            <h3>Academic Performance</h3>

            <table class="marks-table">
                <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($marks)) { ?>
                <tr>
                    <td><?= $row['subject_name'] ?></td>
                    <td><?= $row['marks'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <?php } ?>

    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>

</body>
</html>
