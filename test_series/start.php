<?php
session_start();
include("../config.php");

// Student role check
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../Users/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    $test_id = $_POST['test_id'];
    $answers = $_POST['answers'];
    $score = 0;
    $total = count($answers);

    foreach ($answers as $question_id => $given_answer) {
        $q = mysqli_query($conn, "SELECT correct_question FROM question_series WHERE id='$question_id'");
        $row = mysqli_fetch_assoc($q);
        $correct_answer = $row['correct_question'] ?? '';

        if (trim(strtolower($given_answer)) === trim(strtolower($correct_answer))) {
            $score++;
        }
    }

    $percentage = ($total > 0) ? ($score / $total) * 100 : 0;

    // Show result
    echo "
    <html><head><title>Result</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f4ff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .result-container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; width: 400px; }
        .result-container h2 { margin-bottom: 20px; }
        .score-box { margin: 10px 0; font-size: 18px; }
        .score-box span { font-weight: bold; color: #4c63ff; }
        .btn { margin-top: 20px; padding: 12px 25px; background: #4c63ff; color: #fff; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; }
        .btn:hover { background: #364ed5; }
    </style>
    </head><body>
    <div class='result-container'>
        <h2>Test Completed!</h2>
        <div class='score-box'>Total Questions: <span>$total</span></div>
        <div class='score-box'>Correct Answers: <span>$score</span></div>
        <div class='score-box'>Wrong Answers: <span>" . ($total - $score) . "</span></div>
        <div class='score-box'>Score: <span>" . round($percentage, 2) . "%</span></div>
        <button class='btn' onclick=\"window.location.href='../Dashboard/student_dashboard.php'\">Go to Dashboard</button>
    </div>
    </body></html>
    ";
    exit();
}

// GET request — Display questions
if (isset($_GET['test_id'])) {
    $test_id = $_GET['test_id'];
    $questions = mysqli_query($conn, "SELECT * FROM question_series WHERE test_id='$test_id'");
} else {
    echo "No test selected.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Start Test</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #8e9eab, #eef2f3);
            padding: 30px;
        }
        .question-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .question-text {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .option {
            margin: 5px 0;
        }
        .btn {
            padding: 12px 25px;
            background: #4c63ff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .btn:hover {
            background: #364ed5;
        }
    </style>
</head>
<body>

<form method="POST" action="start.php">
    <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">

    <?php
    $i = 1;
    while ($q = mysqli_fetch_assoc($questions)) {
        echo "<div class='question-box'>";
        echo "<div class='question-text'>Q$i. " . $q['question'] . "</div>";
        echo "<div class='option'><input type='radio' name='answers[" . $q['id'] . "]' value='" . $q['option_a'] . "' required> " . $q['option_a'] . "</div>";
        echo "<div class='option'><input type='radio' name='answers[" . $q['id'] . "]' value='" . $q['option_b'] . "'> " . $q['option_c'] . "</div>";
        echo "<div class='option'><input type='radio' name='answers[" . $q['id'] . "]' value='" . $q['option_c'] . "'> " . $q['option_c'] . "</div>";
        echo "<div class='option'><input type='radio' name='answers[" . $q['id'] . "]' value='" . $q['option_d'] . "'> " . $q['option_d'] . "</div>";
        echo "</div>";
        $i++;
    }
    ?>

    <button class="btn" type="submit">Submit Test</button>
</form>

</body>
</html>
