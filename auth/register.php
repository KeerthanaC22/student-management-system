<?php
include("../config/db.php");

$error = "";

if (isset($_POST['register'])) {

    // Collect form data
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $roll     = $_POST['roll'];
    $fname    = $_POST['fname'];
    $lname    = $_POST['lname'];
    $gender   = $_POST['gender'];
    $phone    = $_POST['phone'];

    // 1️⃣ Insert into users table (ROLE = student)
    $user_query = "INSERT INTO users (username, email, password, role)
                   VALUES ('$username', '$email', '$password', 'student')";

    if (mysqli_query($conn, $user_query)) {

        // 2️⃣ Get generated user_id
        $user_id = mysqli_insert_id($conn);

        // 3️⃣ Insert into students table (IMPORTANT PART)
        $student_query = "INSERT INTO students
            (user_id, roll_number, first_name, last_name, gender, email, phone)
            VALUES
            ($user_id, '$roll', '$fname', '$lname', '$gender', '$email', '$phone')";

        if (mysqli_query($conn, $student_query)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Student profile creation failed.";
        }

    } else {
        $error = "Username or email already exists.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="../assects/css/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <h2>Create Account</h2>
        <h2 class="subtitle">Student Registration</h2>

        <?php if ($error) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

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
                <label>Gender</label>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" required>
            </div>

            <button name="register" class="btn">Register</button>
        </form>

        <p class="switch">
            Already registered? <a href="login.php">Login</a>
        </p>

    </div>
</div>

</body>
</html>
