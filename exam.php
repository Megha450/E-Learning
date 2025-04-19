<!-- exam.php -->
<?php
session_start();

// Redirect if not student
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../Users/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Subject - Test Series</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .exam-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            text-align: center;
        }
        select, button {
            padding: 10px;
            width: 100%;
            margin: 15px 0;
            border-radius: 8px;
            border: 1px solid #999;
        }
        button {
            background: #6d5dfc;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #5848d6;
        }
    </style>
</head>
<body>

<div class="exam-box">
    <h2>Select Subject to Start Test</h2>
    <form action="test_list.php" method="POST">
        <select name="subject" required>
            <option value="">-- Choose Subject --</option>
            <option value="Science">Science</option>
            <option value="Maths">Maths</option>
            <option value="Computer">Computer</option>
        </select>
        <button type="submit">Show Tests</button>
    </form>
</div>

</body>
</html>
