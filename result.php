<?php
session_start();
include '../config.php'; // Adjust path as needed

// Check if test_id and session answers exist
if (!isset($_GET['test_id']) || !isset($_SESSION['answers'])) {
    die("Invalid access to result page.");
}

$test_id = $_GET['test_id'];
$userAnswers = $_SESSION['answers'];

// Fetch all questions for this test
$query = mysqli_query($conn, "SELECT * FROM question_series WHERE test_id = '$test_id'");
$questions = [];
while ($row = mysqli_fetch_assoc($query)) {
    $questions[] = $row;
}

// Score Calculation
$score = 0;
$total = count($questions);

foreach ($questions as $index => $q) {
    $qn = $index + 1;
    $correct = strtolower($q['correct_question']);
    $selected = strtolower($userAnswers[$qn] ?? '');
    if ($selected === $correct) {
        $score++;
    }
}

// Clear session answers
unset($_SESSION['answers']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Result</title>
    <style>
        body { font-family: Arial; background: #eef2f3; padding: 20px; }
        .box { background: white; padding: 30px; border-radius: 10px; width: 700px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.2); }
        h2 { color: #2c3e50; }
        .score { font-size: 24px; margin: 20px 0; }
        .result-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .result-table th, .result-table td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .correct { color: green; }
        .wrong { color: red; }
    </style>
</head>
<body>

<div class="box">
    <h2>Test Result</h2>
    <p class="score">You scored <strong><?php echo $score; ?></strong> out of <strong><?php echo $total; ?></strong></p>

    <h3>Question Review:</h3>
    <table class="result-table">
        <tr>
            <th>#</th>
            <th>Question</th>
            <th>Your Answer</th>
            <th>Correct Answer</th>
        </tr>
        <?php foreach ($questions as $index => $q): ?>
            <?php
                $qn = $index + 1;
                $selected = strtolower($userAnswers[$qn] ?? 'Not answered');
                $correct = strtolower($q['correct_question']);

                $options = [
                    'a' => $q['option_a'],
                    'b' => $q['option_b'],
                    'c' => $q['option_c'],
                    'd' => $q['option_d'],
                ];

                $yourAnswer = $options[$selected] ?? 'Not answered';
                $correctAnswer = $options[$correct] ?? 'Unknown';
                $class = ($selected === $correct) ? 'correct' : 'wrong';
            ?>
            <tr>
                <td><?php echo $qn; ?></td>
                <td><?php echo $q['question']; ?></td>
                <td class="<?php echo $class; ?>"><?php echo ucfirst($yourAnswer); ?></td>
                <td class="correct"><?php echo ucfirst($correctAnswer); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br><br>
    <a href="exam.php"><button>Practice More</button></a>
    <a href="../Dashboard/student_dashboard.php"><button>Go to Dashboard</button></a>
</div>

</body>
</html>
