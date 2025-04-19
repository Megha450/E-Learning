<form method="POST" action="">
    <input type="text" name="test_name" placeholder="Add Test Name" required>
    <input type="text" name="title" placeholder="Test Title" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <input type="number" name="total_questions" placeholder="Total Questions" required>
    <input type="number" name="duration" placeholder="Duration (in minutes)" required>
    <button type="submit" name="addTest">Add Test</button>
</form>

<?php
include("../config.php");
if(isset($_POST['addTest'])) {
    $test_name=$_post['test_name'];
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $total = $_POST['total_questions'];
    $duration = $_POST['duration'];

    $query = "INSERT INTO test_series (test_name,title,subject,total_questions, duration)
              VALUES ('$test_name','$title', '$subject', $total, $duration)";
    if(mysqli_query($conn, $query)) {
        // echo "<script>alert('Test Added Successfully');</script>";
        header("Location: add_question.php");
       
    } else {
        echo "<script>alert('Error adding test');</script>";
    }
}
?>
