<?php
include 'db.php';

// Get course code from query string
if (isset($_GET['edit'])) {
    $code = $_GET['edit'];

    // Fetch current course data
    $result = $conn->query("SELECT * FROM Course 
                            INNER JOIN Manage ON Course.Ccode = Manage.Code 
                            WHERE Ccode = '$code'");
    $course = $result->fetch_assoc();

    if (!$course) {
        echo "Course not found!";
        exit();
    }
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ccode = $_POST['ccode'];
    $cname = $_POST['cname'];
    $credit = $_POST['credit'];
    $lecture_hours = $_POST['lecture_hours'];
    $semester = $_POST['semester'];
    $maid = $_POST['maid'];

    // Update Course table
    $conn->query("UPDATE Course 
                  SET Cname='$cname', Credit=$credit, LectureHours=$lecture_hours 
                  WHERE Ccode='$ccode'");

    // Update Manage table
    $conn->query("UPDATE Manage 
                  SET Semester=$semester, MAid=$maid 
                  WHERE Code='$ccode'");

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="Edit.css">
</head>
<body>

<div class="container">
    <h2>Edit Course</h2>
    <form method="POST">
        <input type="hidden" name="ccode" value="<?php echo $course['Ccode']; ?>">

        <label>Course Name:</label>
        <input type="text" name="cname" value="<?php echo $course['Cname']; ?>" required><br>

        <label>Credits:</label>
        <input type="number" name="credit" value="<?php echo $course['Credit']; ?>" required><br>

        <label>Lecture Hours:</label>
        <input type="number" name="lecture_hours" value="<?php echo $course['LectureHours']; ?>" required><br>

        <label>Semester:</label>
        <input type="number" name="semester" value="<?php echo $course['Semester']; ?>" required><br>

        <label>MA ID:</label>
        <input type="number" name="maid" value="<?php echo $course['MAid']; ?>" required><br>

        <input type="submit" value="Update Course" class="update-btn">
        <a href="index.php" class="cancel-btn">Cancel</a>
    </form>
</div>

</body>
</html>
