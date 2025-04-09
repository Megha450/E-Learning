<?php
include '../config.php'; // update path to your DB connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $uploaded_by = $_SESSION['user_id']; // Assuming you're storing user ID in session
    $uploaded_at = date('Y-m-d H:i:s');

    // File upload handling
    $targetDir = "uploads/study_materials/";
    $fileName = basename($_FILES["file"]["name"]);
    $fileTmp = $_FILES["file"]["tmp_name"];
    $newFileName = time() . "_" . preg_replace("/[^A-Za-z0-9.]/", "_", $fileName);
    $targetFilePath = $targetDir . $newFileName;

    if (move_uploaded_file($fileTmp, $targetFilePath)) {
        $sql = "INSERT INTO study_materials (title, description, file_path, subject, uploaded_by, uploaded_at)
                VALUES ('$title', '$description', '$targetFilePath', '$subject', '$uploaded_by', '$uploaded_at')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Study material uploaded successfully'); window.location.href='upload_material.php';</script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload_Materials</title>
</head>
<body>
<h2>Upload Study Material</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" required></textarea><br><br>

    <label>Subject:</label><br>
    <select name="subject" required>
        <option value="">Select Subject</option>
        <option value="Science">Science</option>
        <option value="Maths">Maths</option>
        <option value="Computer">Computer</option>
        <!-- Add more subjects as needed -->
    </select><br><br>

    <label>Choose PDF File:</label><br>
    <input type="file" name="file" accept="application/pdf" required><br><br>

    <button type="submit">Upload</button>
</form>

</body>
</html>