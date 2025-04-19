<?php
session_start();
include '../config.php'; // Adjust the path as needed

// Get test_id from URL
if (!isset($_GET['test_id'])) {
    die("Test ID not provided.");
}
$test_id = $_GET['test_id'];

// Fetch test details
$testQuery = mysqli_query($conn, "SELECT * FROM test_series WHERE id = '$test_id'");
$test = mysqli_fetch_assoc($testQuery);

// Fetch total questions
$questionQuery = mysqli_query($conn, "SELECT * FROM question_series WHERE test_id = '$test_id'");
$totalQuestions = mysqli_num_rows($questionQuery);

// Determine current question number
$currentQuestion = isset($_GET['q']) ? (int)$_GET['q'] : 1;

// Fetch specific question
$offset = $currentQuestion - 1;
$questionSql = "SELECT * FROM question_series WHERE test_id = '$test_id' LIMIT 1 OFFSET $offset";
$questionResult = mysqli_query($conn, $questionSql);
$question = mysqli_fetch_assoc($questionResult);

// Store answer on submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['answer'] ?? '';
    $_SESSION['answers'][$currentQuestion] = $selected;

    if ($currentQuestion < $totalQuestions) {
        header("Location: start.php?test_id=$test_id&q=" . ($currentQuestion + 1));
        exit();
    } else {
        header("Location: result.php?test_id=$test_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $test['title']; ?> - Question <?php echo $currentQuestion; ?></title>
    <style>
        body { font-family: Arial; background: #f0f8ff; padding: 20px; }
        .box { background: white; padding: 20px; border-radius: 10px; width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.2); }
        h2, h3 { color: #333; }
        input[type="submit"] { padding: 10px 20px; background: #2b90d9; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="box">
    <h2><?php echo $test['title']; ?> (<?php echo $test['subject']; ?>)</h2>
    <p><strong>Question <?php echo $currentQuestion; ?> of <?php echo $totalQuestions; ?></strong></p>

    <?php if ($question): ?>
        <form method="POST">
            <h3><?php echo $question['question']; ?></h3>
            <label><input type="radio" name="answer" value="a" required> <?php echo $question['option_a']; ?></label><br>
            <label><input type="radio" name="answer" value="b"> <?php echo $question['option_b']; ?></label><br>
            <label><input type="radio" name="answer" value="c"> <?php echo $question['option_c']; ?></label><br>
            <label><input type="radio" name="answer" value="d"> <?php echo $question['option_d']; ?></label><br><br>

            <input type="submit" value="<?php echo ($currentQuestion == $totalQuestions) ? 'Submit Test' : 'Next'; ?>">
        </form>
    <?php else: ?>
        <p>Question not found!</p>
    <?php endif; ?>
</div>

</body>
</html>
