<?php
$conn = mysqli_connect("localhost", "root", "", "lms_db");

$selected_subject = isset($_GET['subject']) ? $_GET['subject'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Study Materials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .subject-buttons {
            text-align: center;
            margin-bottom: 20px;
        }
        .subject-buttons a {
            margin: 5px;
            padding: 10px 20px;
            background: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .subject-buttons a:hover {
            background: #0056b3;
        }
        .material {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #007BFF;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .material h3 {
            margin: 0;
        }
        .material a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Available Study Materials</h2>

<div class="subject-buttons">
    <a href="view_material.php?subject=Science">Science</a>
    <a href="view_material.php?subject=Maths">Maths</a>
    <a href="view_material.php?subject=Computer">Computer</a>
    <a href="view_material.php">All</a>
</div>

<?php
$sql = "SELECT * FROM study_materials";

if (!empty($selected_subject)) {
    $sql .= " WHERE subject = '" . mysqli_real_escape_string($conn, $selected_subject) . "'";
}

$sql .= " ORDER BY uploaded_at DESC";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='material'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p><strong>Subject:</strong> " . htmlspecialchars($row['subject']) . "</p>";
        echo "<a href='" . $row['file_path'] . "' download>Download PDF</a>";
        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;'>No study materials found for this subject.</p>";
}
?>

</body>
</html>
