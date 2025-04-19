<?php
session_start();
include("../config.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../Users/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject'])) {
    $subject = $_POST['subject'];

    $query = "SELECT * FROM test_series WHERE subject = '$subject'";
    $result = mysqli_query($conn, $query);
} else {
    echo "No subject selected.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Tests</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #c3ecf7, #f5c6ec);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .test-list-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
        }

        .test-box {
            background: #f7f9ff;
            padding: 18px 20px;
            margin-bottom: 15px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            border: 1px solid #e0e7ff;
        }

        .test-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }

        .test-box strong {
            color: #4b4b4b;
            font-weight: 600;
        }

        .start-btn {
            padding: 10px 20px;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .start-btn:hover {
            background: linear-gradient(to right, #5a67d8, #6b46c1);
            transform: scale(1.05);
        }

        p {
            text-align: center;
            color: #555;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="test-list-container">
    <h2>Available Tests for <?php echo htmlspecialchars($subject); ?></h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($test = mysqli_fetch_assoc($result)) {
            echo "
            <div class='test-box'>
                <div><strong>" . htmlspecialchars($test['test_name']) . "</strong></div>
                <form action='start.php' method='GET'>
                    <input type='hidden' name='test_id' value='" . $test['id'] . "'>
                    <button type='submit' class='start-btn'>Start Test</button>
                </form>
            </div>
            ";
        }
    } else {
        echo "<p>No tests available for this subject.</p>";
    }
    ?>
</div>

</body>
</html>
