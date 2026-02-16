<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: auth/login.php");
    exit();
}

/* ===========================
   COUNT TOTAL STUDENTS
   =========================== */
$studentCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM students")
)['total'];

/* ===========================
   FETCH AVERAGE MARKS BY SUBJECT
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
    <title>Teacher Dashboard</title>

    <!-- ✅ CORRECT CSS PATH -->
     <link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assects/css/student.css?v=1">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <h2>Teacher Dashboard</h2>
</div>

<!-- WRAPPER -->
<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">✖</span>
        
        <div id="dbheading">
        <h2 >Teacher</h2>
        </div>
        <a href="dashboard.php" class="active">
    <i class="fa-solid fa-house"></i>
    Dashboard
  </a>

  <a href="students/add.php">
    <i class="fa-solid fa-user-plus"></i>
    Add Student
  </a>

  <a href="students/list.php">
    <i class="fa-solid fa-users"></i>
    View Students
  </a>

  <a href="marks/add.php">
    <i class="fa-solid fa-pen-to-square"></i>
    Add Marks
  </a>

  <a href="subject/add.php">
    <i class="fa-solid fa-book"></i>
    Add Subject
  </a>

  <a href="subject/list.php">
    <i class="fa-solid fa-list"></i>
    View Subjects
  </a>

  <a href="auth/logout.php" class="logout">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
  </a>
        <!-- <a href="dashboard.php" class="active">🏠 Dashboard</a>
        <a href="students/add.php">Add Student</a>
        <a href="students/list.php">View Students</a>
        <a href="marks/add.php">Add Marks</a>
        <a href="subject/add.php">Add Subject</a>
        <a href="subject/list.php">View Subjects</a>
        <a href="auth/logout.php" class="logout">Logout</a> -->
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- Welcome -->
        <div class="card">
            <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
            <p>Use the menu to manage students and upload marks.</p>
        </div>

        <!-- COUNT CARD -->
        <div class="card">
            <h3>Students Overview</h3>

            <div style="background:rgb(46, 162, 46); color:#fff; padding:20px;
                        border-radius:10px; width:220px;">
                <h4>Total Students</h4>
                <p style="font-size:30px; font-weight:bold;">
                    <?php echo $studentCount; ?>
                </p>
            </div>
        </div>

        <!-- GRAPH CARD -->
        <div class="card">
            <h3>Average Marks by Subject</h3>
            <canvas id="avgMarksChart" height="120"></canvas>
        </div>

        <!-- Notifications -->
        <div class="card">
            <h3>Notifications</h3>

            <div class="notification">
                Remember to update marks after exams
            </div>

            <div class="notification empty">
                No new notifications
            </div>
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}

/* ===========================
   DRAW AVERAGE MARKS CHART
   =========================== */
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
