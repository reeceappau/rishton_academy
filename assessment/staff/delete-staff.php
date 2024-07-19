<?php

require_once('../functions/initialize.php');


if (!isset($_GET['id'])) {
    header("Location: manage-staff.php");
} 

$id = $_GET['id'];

$sql = "SELECT * FROM staff WHERE id={$id}";
$result = mysqli_query($connection, $sql);
$staff = mysqli_fetch_assoc($result);

if (!$staff) {
    header("Location: manage-staff.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "DELETE FROM staff WHERE id={$id}";
    $result = mysqli_query($connection, $sql);
    if($result) {
        $sql = "DELETE FROM address WHERE id={$staff['address_id']}";
        $result = mysqli_query($connection, $sql);
        if($result) {
            set_session_message("Staff deleted successfully");
            header("Location: manage-staff.php");
        } else {
            $errors[] = "Failed to delete staff address";
        }
    } else {
        $errors[] = "Failed to delete staff";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Staff Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>


<div class="container mt-5">
    <h1 class="mb-4 text-center">Delete Staff Confirmation</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Are you sure you want to delete this staff member?</h5>
            <p><strong>Name:</strong> <?php echo ("{$staff['first_name']} {$staff['last_name']}");?></p>
            <p><strong>Email:</strong> <?php echo $staff['email']; ?></p>
            <p><strong>Role:</strong> <?php echo $staff['role']; ?></p>
            <p class="text-danger">This action cannot be undone!</p>
        </div>
    </div>
    <div class="mt-4">
        <form action="delete-staff.php?id=<?php echo $id;?>" method="post">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="manage-staff.php" class="btn btn-secondary">Cancel</a>
        </form>
        
    </div>
</div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
