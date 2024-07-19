<?php
require_once('../functions/initialize.php');

if (!isset($_GET['id'])) {
    header("Location: manage-classes.php");
    exit;
}

$class_id = $_GET['id'];

// Fetch class details
$sql = "SELECT *, (SELECT COUNT(*) FROM student WHERE class_id = class.id) AS capacity FROM class WHERE id = {$class_id}";
$class_result = mysqli_query($connection, $sql);
$class = mysqli_fetch_assoc($class_result);

if (!$class) {
    header("Location: manage-classes.php");
    exit;
}

// Fetch available teachers who are not assigned to other classes
$sql = "SELECT * FROM staff 
        WHERE role = 'teacher' 
        AND id NOT IN (SELECT teacher_id FROM class WHERE teacher_id IS NOT NULL AND id != {$class_id})";
$staff_result = mysqli_query($connection, $sql);
$teachers = [];
while ($row = mysqli_fetch_assoc($staff_result)) {
    $teachers[] = $row;
}

// Fetch available assistants who are not assigned to other classes
$sql = "SELECT * FROM staff 
        WHERE role = 'assistant' 
        AND id NOT IN (SELECT assistant_id FROM class WHERE assistant_id IS NOT NULL AND id != {$class_id})";
$staff_result = mysqli_query($connection, $sql);
$assistants = [];
while ($row = mysqli_fetch_assoc($staff_result)) {
    $assistants[] = $row;
}

// Fetch students in the class
$sql = "SELECT id, first_name, last_name FROM student WHERE class_id = {$class_id}";
$students_result = mysqli_query($connection, $sql);
$students = [];
while ($row = mysqli_fetch_assoc($students_result)) {
    $students[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_POST['teacher_id'] ?? null;
    $assistant_id = $_POST['assistant_id'] ?? null;

    // Update class with new teacher and assistant
    $sql = "UPDATE class SET teacher_id = " . ($teacher_id ? $teacher_id : "NULL") . ", assistant_id = " . ($assistant_id ? $assistant_id : "NULL") . " WHERE id = {$class_id}";
    $result = mysqli_query($connection, $sql);
    
    if ($result) {
        header("Location: manage-classes.php");
        exit;
    } else {
        $error_message = "Failed to update class.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo htmlspecialchars($class['name']); ?></h1>

        <p><strong>Capacity:</strong> <?php echo $class['capacity']; ?> students</p>

        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <form class="my-5" method="POST" action="view-class.php?id=<?php echo $class_id; ?>">
            <div class="mb-3">
                <label for="teacher" class="form-label">Teacher</label>
                <select class="form-select" id="teacher" name="teacher_id">
                    <option value="">Select a teacher</option>
                    <?php foreach ($teachers as $member) { ?>
                    <option value="<?php echo $member['id']; ?>" <?php echo ($class['teacher_id'] == $member['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="assistant" class="form-label">Teaching Assistant</label>
                <select class="form-select" id="assistant" name="assistant_id">
                    <option value="">Select a teaching assistant</option>
                    <?php foreach ($assistants as $member) { ?>
                    <option value="<?php echo $member['id']; ?>" <?php echo ($class['assistant_id'] == $member['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Staff Assignment</button>
        </form>
        

        <h2 class="h3 mt-4">Students in this Class</h2>
        <?php if (count($students) > 0) { ?>
            <ul class="list-group">
                <?php foreach ($students as $student) { ?>
                    <li class="list-group-item">
                        <a href="../students/view-student.php?id=<?php echo $student['id']; ?>" class="btn btn-link">
                            <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No students enrolled in this class.</p>
        <?php } ?>
    </div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
