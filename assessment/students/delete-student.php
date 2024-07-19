<?php

require_once('../functions/initialize.php');


if (!isset($_GET['id'])) {
    header("Location: manage-students.php");
} 

$id = $_GET['id'];

$sql = "SELECT * FROM student WHERE id={$id}";
$result = mysqli_query($connection, $sql);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    header("Location: manage-students.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "DELETE FROM student WHERE id={$id}";
    $result = mysqli_query($connection, $sql);
    if($result) {
        $sql = "DELETE FROM parent WHERE id={$student['parent_id']}";
        $result = mysqli_query($connection, $sql);
        if($result) {
            $sql = "DELETE FROM address WHERE id={$student['address_id']}";
            $result = mysqli_query($connection, $sql);
            if($result) {
                set_session_message("Student deleted successfully");
                header("Location: manage-students.php");
            } else {
                $errors[] = "Failed to delete student address";
            }
        } else {
            $errors[] = "Failed to delete student parent";
        }
    } else {
        $errors[] = "Failed to delete student";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>


<div class="container mt-5">
    <h1 class="mb-4 text-center">Delete Student Confirmation</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Are you sure you want to delete this student?</h5>
            <p><strong>Name:</strong> <?php echo ("{$student['first_name']} {$student['last_name']}");?></p>
            <p class="text-danger">This action cannot be undone!</p>
        </div>
    </div>
    <div class="mt-4">
        <form action="delete-student.php?id=<?php echo $id;?>" method="post">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="manage-students.php" class="btn btn-secondary">Cancel</a>
        </form>
        
    </div>
</div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
