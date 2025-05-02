<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert new course data
    $ccode = $_POST['ccode'];
    $cname = $_POST['cname'];
    $credit = $_POST['credit'];
    $lecture_hours = $_POST['lecture_hours'];
    $semester = $_POST['semester'];
    $maid = $_POST['maid'];

    // Insert into Course table
    $conn->query("INSERT INTO Course (Ccode, Cname, Credit, LectureHours) VALUES ('$ccode', '$cname', $credit, $lecture_hours)");

    // Insert into Manage table
    $conn->query("INSERT INTO Manage (Code, MAid, Semester) VALUES ('$ccode', $maid, $semester)");

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
    <link rel="stylesheet" href="add.css">
</head>
<body>

<div class="container">
    <h2 style="margin-bottom: 20px; color: #00796b;">Add New Course</h2>

    <form method="POST" class="course-form">
        <label>Course Code:</label>
        <input type="text" name="ccode" required>

        <label>Course Name:</label>
        <input type="text" name="cname" required>

        <label>Credit:</label>
        <input type="number" name="credit" required>

        <label>Lecture Hours:</label>
        <input type="number" name="lecture_hours" required>

        <label>Semester:</label>
        <input type="number" name="semester" required>

        <label>MA ID:</label>
        <input type="number" name="maid" required>

        <div style="margin-top: 15px;">
            <input type="submit" value="Add Course" class="search-button">
            <a href="index.php" class="add-course-btn" style="margin-left: 10px;">Back</a>
        </div>
    </form>
</div>

</body>
</html>
