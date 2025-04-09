<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Users/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['answers']) || !isset($_SESSION['subject']) || !isset($_SESSION['test_id'])) {
    echo "Session expired or incomplete!";
    exit();
}

$answers = $_SESSION['answers'];
$subject = $_SESSION['subject'];
$test_id = $_SESSION['test_id'];

$total_questions = count($answers);
$correct_answers = 0;

// Loop through user answers and compare with correct ones from DB
foreach ($answers as $question_id => $user_answer) {
    $query = "SELECT correct_question FROM question_series WHERE id = $question_id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $correct = $row['correct_question'];
        if (strtolower(trim($correct)) === strtolower(trim($user_answer))) {
            $correct_answers++;
        }
    }
}

// Calculate result
$wrong_answers = $total_questions - $correct_answers;
$percentage = ($correct_answers / $total_questions) * 100;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Result</title>
    <style>
        body { font-family: Arial; background: #f0f4ff; text-align: center; padding: 50px; }
        .result-box {
            background: white; padding: 30px; border-radius: 10px; display: inline-block;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); min-width: 300px;
        }
        h2 { margin-bottom: 20px; color: #333; }
        p { font-size: 18px; margin: 10px 0; }
        .btn {
            padding: 10px 20px; border: none; border-radius: 5px;
            background: #4c63ff; color: white; cursor: pointer; margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="result-box">
        <h2>Result for <?php echo ucfirst($subject); ?> Test</h2>
        <p><strong>Total Questions:</strong> <?php echo $total_questions; ?></p>
        <p><strong>Correct Answers:</strong> <?php echo $correct_answers; ?></p>
        <p><strong>Wrong Answers:</strong> <?php echo $wrong_answers; ?></p>
        <p><strong>Score:</strong> <?php echo round($percentage, 2); ?>%</p>

        <button class="btn" onclick="window.location.href='../Dashboard/student_dashboard.php'">Go to Dashboard</button>
    </div>
</body>
</html>

<?php
// Optional: clear session values after result is shown
unset($_SESSION['answers']);
unset($_SESSION['subject']);
unset($_SESSION['test_id']);
?>
