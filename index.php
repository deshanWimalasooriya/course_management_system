<?php
include 'db.php';

// Handle the delete action
if (isset($_GET['delete'])) {
    $code = $_GET['delete'];
    // Delete the course from both Course and Manage tables
    $conn->query("DELETE FROM Manage WHERE Code = '$code'");
    $conn->query("DELETE FROM Course WHERE Ccode = '$code'");
    header("Location: index.php");
    exit();
}

// Handle the edit action
if (isset($_GET['edit'])) {
    $code = $_GET['edit'];
    // Fetch the course details for editing
    $result = $conn->query("SELECT * FROM Course WHERE Ccode = '$code'");
    $course = $result->fetch_assoc();
}


// Handle the search action
$semester = isset($_POST['semester']) ? $_POST['semester'] : "";
$query = "SELECT * FROM Course INNER JOIN Manage ON Course.Ccode = Manage.Code WHERE 1=1 ";

if ($semester != "") {
    $query .= "AND Manage.Semester = '$semester'";
}

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management System</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="header">
    <h1>FACULTY OF ENGINEERING - UNIVERSITY OF JAFFNA</h1>
    <h2>COURSE MANAGEMENT SYSTEM</h2>
</div>

<div class="container">
    <!-- Search bar for semester -->
    <form method="POST" action="index.php" class="search-form">
    <label for="semester">Select Semester:</label>
    <select name="semester" id="semester" class="select-semester" onchange="this.form.submit()">
        <?php
        // Get distinct semesters
        $semesters = $conn->query("SELECT DISTINCT Semester FROM Manage ORDER BY Semester");
        $default = ($semester != "") ? $semester : "1"; // Default to Semester 1 if not selected

        while ($row = $semesters->fetch_assoc()) {
            $selected = ($default == $row['Semester']) ? " selected" : "";
            echo "<option value='{$row['Semester']}'$selected>Semester {$row['Semester']}</option>";
        }
        ?>
    </select>
    </form>


    <!-- Add New Course Button -->
    <a href="add_course.php" class="add-course-btn">Add New Course</a>

    <?php if ($semester != ""): ?>
        <!-- Courses Table -->
        <table class="courses-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>Lecture Hours</th>
                    <th>Semester</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['Ccode']; ?></td>
                        <td><?php echo $row['Cname']; ?></td>
                        <td><?php echo $row['Credit']; ?></td>
                        <td><?php echo $row['LectureHours']; ?></td>
                        <td><?php echo $row['Semester']; ?></td>
                        <td class="action-buttons">
                            <!-- Edit Button -->
                            <a href="edit.php?edit=<?php echo $row['Ccode']; ?>" class="edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <!-- Delete Button -->
                            <a href="index.php?delete=<?php echo $row['Ccode']; ?>" 
                                onclick="return confirm('Are you sure you want to delete this course?')" 
                                class="delete-btn">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
