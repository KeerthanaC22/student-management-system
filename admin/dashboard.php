<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
/* ===========================
   FETCH COUNTS
   =========================== */

// Count teachers
$teacherCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='teacher'")
)['total'];

// Count students
$studentCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='student'")
)['total'];


/* ===========================
   FETCH AVERAGE MARKS DATA
   =========================== */
$avgQuery = mysqli_query($conn,
    "SELECT s.subject_name, AVG(m.marks) AS avg_marks
     FROM marks m
     JOIN subjects s ON m.subject_id = s.subject_id
     GROUP BY s.subject_id"
);

$subjects = [];
$averages = [];

while ($row = mysqli_fetch_assoc($avgQuery)) {
    $subjects[] = $row['subject_name'];
    $averages[] = round($row['avg_marks'], 2);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- ✅ FIXED CSS PATH -->
    <link rel="stylesheet" href="../assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Admin Dashboard</h2>
</div>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">✖</span>

        <h2 id="dbheading">Admin</h2>

        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="add_teacher.php">Add Teacher</a>
        <a href="list_teachers.php">View Teachers</a>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- Welcome Card -->
        <div class="card">
            <h3>Welcome</h3>
            <p>Welcome, <b><?php echo $_SESSION['username']; ?></b></p>
        </div>

       <!-- COUNTS -->
<div class="card">
    <h3>System Overview</h3>

    <div style="display:flex; gap:20px; margin-top:15px; flex-wrap:wrap;">

        <div style="flex:1; min-width:200px; background:#2563eb; color:#fff;
                    padding:20px; border-radius:10px;">
            <h4>Teachers</h4>
            <p style="font-size:28px; font-weight:bold;">
                <?php echo $teacherCount; ?>
            </p>
        </div>

        <div style="flex:1; min-width:200px; background:#16a34a; color:#fff;
                    padding:20px; border-radius:10px;">
            <h4>Students</h4>
            <p style="font-size:28px; font-weight:bold;">
                <?php echo $studentCount; ?>
            </p>
        </div>

    </div>
</div>


        <!-- GRAPH CARD -->
        <div class="card">
            <h3>Average Marks by Subject</h3>
            <canvas id="avgMarksChart" height="120"></canvas>
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}

const ctx = document.getElementById('avgMarksChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($subjects); ?>,
        datasets: [{
            label: 'Average Marks',
            data: <?php echo json_encode($averages); ?>,
            backgroundColor: '#2563eb'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>

</body>
</html>
