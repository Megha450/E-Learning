<?php
include("../config.php");
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location:../Users/login.php");
    exit();
}
$name = $_SESSION['name'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background: linear-gradient(135deg,rgb(219, 218, 234),rgb(245, 202, 245));
            color: #fff;
        }
        .sidebar {
            width: 250px;
            background: #1f1f2e;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
            transition: 0.3s;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            text-decoration: none;
            color: #fff;
            padding: 10px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #6d5dfc;
        }
        .content {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            color: #333;
            text-align: center;
            width: 400px;
        }
        button.logout {
            padding: 10px 20px;
            background: #ff4757;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }
        button.logout:hover {
            background: #e84118;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Student Panel</h2>
        <a href="#">Dashboard</a>
        <a href="#">Courses</a>
        <a href="../test_series/exam.php">Exams</a>
        <a href="../test_series/result.php">View Result</a>

        <a href="#">Profile</a>
        <a href="../Users/logout.php">Logout</a>
    </div>
    <div class="content">
        <div class="profile-card">
            <h2>Welcome, <?php echo htmlspecialchars($name); ?></h2>
            <p><?php echo htmlspecialchars($email); ?></p>
            <button class="logout" onclick="window.location.href='../Users/logout.php'">Logout</button>
        </div>
    </div>
</body>
</html>
