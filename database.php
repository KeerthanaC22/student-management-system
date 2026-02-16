<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/css/style.css">
<title>Dashboard</title>
</head>
<body>

<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>

<a href="students/list.php">Manage Students</a><br><br>
<a href="auth/logout.php">Logout</a>

</body>
</html>
