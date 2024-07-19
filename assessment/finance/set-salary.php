<?php

require_once('../functions/initialize.php');

if (!isset($_GET['id'])) {
    header("Location: salary.php");
} 

$id = $_GET['id'];

$sql = "SELECT staff.id, staff.first_name, staff.last_name, staff.role, salary.salary
FROM staff
LEFT JOIN salary ON staff.id = salary.staff_id
WHERE staff.id = {$id}";
$result = mysqli_query($connection, $sql);
$staff = mysqli_fetch_assoc($result);


 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $salary = $_POST['salary'];

    if (is_blank($salary)){
        $errors[] = "Please enter salary";
    }

    if ($salary < 1) {
        $errors[] = "Salary cannot be less than 1";
    }

    if (empty($errors)){
        $sql = "SELECT * FROM salary WHERE staff_id = {$id}";
        $result = mysqli_query($connection, $sql);

        if(mysqli_num_rows($result) > 0) {
            $sql = "UPDATE salary SET salary = {$salary} WHERE staff_id = {$id}";
            $result = mysqli_query($connection, $sql);
            if($result) {
                set_session_message("Salary updated successfully");
                header("Location: salary.php");
            } else {
                $errors[] = "Failed to update salary";
            }
        } else {
            $sql = "INSERT INTO salary (staff_id, salary) VALUES ({$id}, {$salary})";
            $result = mysqli_query($connection, $sql);
            if($result) {
                set_session_message("Salary set successfully");
                header("Location: salary.php");
            } else {
                $errors[] = "Failed to set salary";
            }
        }
    
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set/Edit Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Set/Edit Salary</h1>
        <a href="salary.php" class="mb-4 d-block">Back to Salary Management</a>
        <form method="POST" action="set-salary.php?id=<?php echo $staff['id']; ?>">
            <div class="mb-3">
                <label for="staff-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="staff-name" value="<?php echo "{$staff['first_name']} {$staff['last_name']}";?>" readonly>
            </div>
            <div class="mb-3">
                <label for="staff-name" class="form-label">Role</label>
                <input type="text" class="form-control" id="staff-name" value="<?php echo $staff['role'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="staff-salary" class="form-label">Salary</label>
                <input type="text" class="form-control" id="staff-salary" name="salary" placeholder="Enter salary" value="<?php echo $staff['salary'];?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Salary</button>
        </form>
    </div>
    <?php include('../shared/footer.php'); ?>
</body>
</html>
