<?php
include("../config.php");

if(isset($_POST['signup'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = trim($_POST['role']); // Role selection

    if(empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)){
        echo "<script>alert('All fields are required!');</script>";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('Invalid email format!');</script>";
    } elseif($password !== $confirm_password){
        echo "<script>alert('Passwords do not match!');</script>";
    } elseif(strlen($password) < 6){
        echo "<script>alert('Password must be at least 6 characters long!');</script>";
    } else {
        // Check if Email already exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            echo "<script>alert('Email already exists!'); window.location.href='login.php';</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users(name, email, password, role) VALUES('$name', '$email', '$hashed_password', '$role')";
            if(mysqli_query($conn, $query)){
                echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Signup</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="signup-container">
    <h2>Create Your Account</h2>
    <form name="signupForm" action="" method="POST" onsubmit="return validateForm()">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <!-- Role Selection Dropdown -->
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" name="signup">Signup</button>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>

<script>
    function validateForm() {
        let password = document.forms["signupForm"]["password"].value;
        let confirm_password = document.forms["signupForm"]["confirm_password"].value;

        if (password !== confirm_password) {
            alert("Passwords do not match!");
            return false;
        }
        return true;
    }
</script>
</body>
</html>

<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    height: 100vh;
    background: linear-gradient(135deg,rgb(8, 8, 10),rgb(59, 77, 164));
    /* background:url(../Users/hhhh.jpg);
    background-repeat:no-repeat; */
    display: flex;
    justify-content: center;
    align-items: center;
}

.signup-container {
    width: 400px;
    padding: 40px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    text-align: center;
}

.signup-container h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 28px;
}

.signup-container input, .signup-container select {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid black;
    border-radius: 10px;
    outline: none;
    background: #f3f3f3;
    transition: 0.3s;
}

.signup-container input:focus, .signup-container select:focus {
    background: #e0e0e0;
}

.signup-container button {
    width: 100%;
    padding: 12px;
    background: #6d5dfc;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.signup-container button:hover {
    background: #405de6;
}

.signup-container p {
    margin-top: 15px;
    font-size: 14px;
}

.signup-container a {
    text-decoration: none;
    color: #6d5dfc;
    font-weight: bold;
}

.signup-container a:hover {
    text-decoration: underline;
}
</style>
