<?php
session_start();
include("../config.php");

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email) || empty($password)){
        $_SESSION['error'] = "All fields are required!";
        header("Location: ../Users/login.php");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = "Invalid Email Format!";
        header("Location:../Users/login.php");
        exit();
    }

    // Secure Query to Prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        // Start Secure Session
        session_regenerate_id(true);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];

        if($row['role'] == 'admin'){
            $_SESSION['success'] = "Welcome Admin!";
            header("Location:../Dashboard/admin_dashboard.php");
        } elseif($row['role'] == 'teacher'){
            $_SESSION['success'] = "Welcome Teacher!";
            header("Location:../Dashboard/teacher_dashboard.php");
        } elseif($row['role'] == 'student'){
            $_SESSION['success'] = "Welcome Student!";
            header("Location:../Dashboard/student_dashboard.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Invalid Credentials!";
        header("Location:../Users/login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LMS</title>
   
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php
        if(isset($_SESSION['error'])){
            echo "<p class='error-msg'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            echo "<p class='success-msg'>".$_SESSION['success']."</p>";
            unset($_SESSION['success']);
        }
    ?>
    <form name="loginForm" action="" method="POST" onsubmit="return validateLogin()">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don't have an account? <a href="../Users/register.php">Signup here</a></p>
</div>

<script>
    function validateLogin() {
        let email = document.forms["loginForm"]["email"].value;
        let password = document.forms["loginForm"]["password"].value;

        if(email == "" || password == "") {
            alert("All fields are required!");
            return false;
        }
        if(!email.match(/^[^ ]+@[^ ]+\.[a-z]{2,3}$/)){
            alert("Invalid Email Format");
            return false;
        }
        if(password.length < 6) {
            alert("Password must be at least 6 characters");
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
    background: linear-gradient(135deg,rgb(17, 19, 21),rgb(98, 88, 210));
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-container {
    width: 400px;
    padding: 40px;
    background:white;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.7);
    text-align: center;
}

.login-container h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 28px;
}

.login-container input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px black solid;
    border-radius: 10px;
    outline: none;
    background: #f3f3f3;
    transition: 0.3s;
}

.login-container input:focus {
    background: #e0e0e0;
}

.login-container button {
    width: 100%;
    padding: 12px;
    background: #6d5dfc;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.login-container button:hover {
    background: #405de6;
}

.login-container p {
    margin-top: 15px;
    font-size: 14px;
}

.login-container a {
    text-decoration: none;
    color: #6d5dfc;
    font-weight: bold;
}

.login-container a:hover {
    text-decoration: underline;
}

.error-msg {
    color: red;
    font-size: 14px;
    background: #ffebeb;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.success-msg {
    color: green;
    font-size: 14px;
    background: #e7ffe7;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}
</style>