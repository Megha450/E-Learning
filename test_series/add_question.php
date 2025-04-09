<?php
include("../config.php");

// Fetch all test series for the dropdown
$testQuery = "SELECT * FROM test_series";
$testResult = mysqli_query($conn, $testQuery);
?>

<h2>Add Question to a Test</h2>

<form method="POST" action="">
    <label>Select Test:</label>
    <select name="test_id" required>
        <option value="">-- Select Test --</option>
        <?php while($row = mysqli_fetch_assoc($testResult)) { ?>
            <option value="<?= $row['id'] ?>"><?= $row['title'] ?> (<?= $row['subject'] ?>)</option>
        <?php } ?>
    </select><br><br>

    <label>Question:</label><br>
    <textarea name="question" rows="4" cols="50" required></textarea><br><br>

    <label>Option A:</label><br>
    <input type="text" name="option_a" required><br><br>

    <label>Option B:</label><br>
    <input type="text" name="option_b" required><br><br>

    <label>Option C:</label><br>
    <input type="text" name="option_c" required><br><br>

    <label>Option D:</label><br>
    <input type="text" name="option_d" required><br><br>

    <label>Correct Option (a/b/c/d):</label><br>
    <input type="text" name="correct_question" maxlength="1" required><br><br>

    <button type="submit" name="add_question">Add Question</button>
</form>

<?php
if (isset($_POST['add_question'])) {
    $test_id = $_POST['test_id'];
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $a = mysqli_real_escape_string($conn, $_POST['option_a']);
    $b = mysqli_real_escape_string($conn, $_POST['option_b']);
    $c = mysqli_real_escape_string($conn, $_POST['option_c']);
    $d = mysqli_real_escape_string($conn, $_POST['option_d']);
    $correct = strtolower($_POST['correct_question']);

    $query = "INSERT INTO question_series 
              (test_id, question, option_a, option_b, option_c, option_d, correct_question)
              VALUES ('$test_id', '$question', '$a', '$b', '$c', '$d', '$correct')";
              
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Question added successfully');</script>";
    } else {
        echo "<script>alert('Error adding question');</script>";
    }
}
?>
