<?php

require_once('../functions/initialize.php');

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $staff = $_POST['staff'];
    $address = $_POST['address'];

    if (is_blank($staff['firstName']) || is_blank($staff['lastName']) || is_blank($staff['email']) || is_blank($staff['phone']) || is_blank($address['address1']) || is_blank($address['zipCode']) || is_blank($staff['role'])){
        $errors[] = "All fields are required";
    }

    if(!has_valid_email_format($staff['email'])) {
        $errors[] = "Email is invalid";
    }

    if(!is_valid_phone($staff['phone'])) {
        $errors[] = "Phone number is invalid";
    }

    if(!is_valid_postcode($address['zipCode'])) {
        $errors[] = "Zip code is invalid";
    }

    if (empty($errors)){
        $sql = "INSERT INTO address (address1, address2, zip_code) VALUES ('{$address['address1']}', '{$address['address2']}', '{$address['zipCode']}')";
        $result = mysqli_query($connection, $sql);
        if($result) {
            $address_id = mysqli_insert_id($connection);
            $sql = "INSERT INTO staff (first_name, last_name, email, phone, role, address_id) VALUES ('{$staff['firstName']}', '{$staff['lastName']}', '{$staff['email']}', '{$staff['phone']}', '{$staff['role']}', '{$address_id}')";
            $result = mysqli_query($connection, $sql);
            if($result) {
                set_session_message("Staff created successfully");
                header("Location: manage-staff.php");
            } else {
                $errors[] = "Failed to create staff";
            }
        } else {
            $errors[] = "Failed to create address";
        }
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Create Staff</h1>
    <p class="mb-4">
        <a href="manage-staff.php" class="link-secondary">Back to Staff Management</a>
    </p>

    <?php echo display_errors($errors); ?>

    <form method="POST" action="create-staff.php">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="staff[firstName]" value="<?php echo $staff['firstName']; ?>">
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="staff[lastName]" value="<?php echo $staff['lastName']; ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="staff[email]" value="<?php echo $staff['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="number" class="form-control" id="phone" name="staff[phone]" value="<?php echo $staff['phone']; ?>">
        </div>
        <div class="mb-3">
            <label for="address1" class="form-label">Address Line 1</label>
            <input type="text" class="form-control" id="address1" name="address[address1]" value="<?php echo $address['address1']; ?>">
        </div>
        <div class="mb-3">
            <label for="address2" class="form-label">Address Line 2</label>
            <input type="text" class="form-control" id="address2" name="address[address2]" value="<?php echo $address['address2']; ?>">
        </div>
        <div class="mb-3">
            <label for="zipCode" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zipCode" name="address[zipCode]" value="<?php echo $address['zipCode']; ?>">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="staff[role]">
                <option value="" disabled selected>Select a role</option>
                <option value="headteacher">Head Teacher</option>
                <option value="teacher">Teacher</option>
                <option value="assistant">Teacher Assistant</option>
                <option value="accountant">Accountant</option>
                <option value="cleaner">Cleaner</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Staff</button>
    </form>
</div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
