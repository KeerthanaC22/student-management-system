<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {

        // Store session data
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] == 'teacher') {
            header("Location: ../dashboard.php"); // teacher dashboard
        } elseif ($user['role'] == 'student') {
            header("Location: ../student/dashboard.php");
        }
        exit();

    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assects/css/style.css">
</head>
<body>

<div class="auth-container">

    <div class="auth-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Login to your account</p>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button name="login" class="btn">Login</button>
        </form>

        <p class="switch">
            Student? <a href="register.php">Create an account</a>
        </p>
    </div>

</div>

</body>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assects/css/style.css">
<title>Login</title>
</head>
<body>
<div class="container">

    

<h2>Login</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

<p>Students only: <a href="register.php">Create account</a></p>
</div>
</body>
</html>

 -->
