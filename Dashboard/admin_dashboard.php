<?php
session_start();
include("../config.php");

if(!isset($_SESSION['email'])){
    echo "<script>alert('Login First!'); window.location.href='../Users/login.php';</script>";
    exit();
}

$email = $_SESSION['email'];
$role = $_SESSION['role'];

if($role != 'admin'){
    echo "<script>alert('Access Denied! Only Admin Allowed'); window.location.href='../Users/login.php';</script>";
    exit();
}

if ($_SESSION['role'] != 'admin') {
    die("Access denied!");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6d5dfc, #405de6);
            color: #fff;
            text-align: center;
            padding: 30px;
        }
        nav {
            background: rgba(0, 0, 0, 0.8);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            gap: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
            background: rgba(255, 255, 255, 0.2);
        }
        nav a:hover {
            background: #e91e63; /* Pink Queen Style 🔥 */
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 0 10px #e91e63;
        }
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }
        .card {
            width: 300px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
            transition: 0.3s ease-in-out;
            text-align: center;
        }
        .card:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: translateY(-10px);
        }
        .card h3 {
            margin-bottom: 10px;
            color: #27ae60;
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<h2>Welcome to Admin Dashboard</h2>
<p>Hello, <?php echo htmlspecialchars($email); ?>!</p>
<p>Your Role: Admin</p>

<nav>
    <a href="../profile.php">Profile</a>
    <a href="../add_course.php">Add Course</a>
    <a href="../upload_material.php">Upload Material</a>
    <a href="../test_series/add_test.php" class="btn">Add Test</a>
    <a href="../test_series/add_question.php" class="btn">Add question</a>
    <a href="../doubts.php">Doubt Section</a>
    <a href="../Users/logout.php">Logout</a>
</nav>

<div class="dashboard-container">
    <div class="card">
        <h3>Total Users</h3>
        <p>500</p>
    </div>
    <div class="card">
        <h3>Total Courses</h3>
        <p>25</p>
    </div>
    <div class="card">
        <h3>Pending Doubts</h3>
        <p>12</p>
    </div>
</div>
</body>
</html>
