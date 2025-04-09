<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'teacher'){
    header("Location:../Users/ login.php");
    exit();
}
$name = isset($_SESSION['name']) ? $_SESSION['name'] : "Teacher";

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'teacher') {
    die("Access denied!");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h1>Welcome, <?php echo $name; ?> 🎓</h1>
    <p style="font-weight:400;">This is the Teacher Dashboard</p>

    <a href="logout.php">
        <button class="logout-btn">Logout</button>
    </a>
</div>
</body>
</html>

<style>
.dashboard-container {
    text-align: center;
    margin-top: 100px;
    padding: 40px;
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    border-radius: 15px;
    width: 50%;
    margin: auto;
}

.dashboard-container h1 {
    color: #6d5dfc;
    font-size: 32px;
}

.logout-btn {
    padding: 10px 20px;
    background: #405de6;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.logout-btn:hover {
    background: #6d5dfc;
}
</style>
