<?php

require_once('../functions/initialize.php');

if (!isset($_GET['id'])) {
    header("Location: manage-staff.php");
    exit;
} 

$id = $_GET['id']; 

// Fetch staff and address details using a JOIN query
$sql = "SELECT staff.*, address.address1, address.address2, address.zip_code 
        FROM staff 
        LEFT JOIN address ON staff.address_id = address.id 
        WHERE staff.id = {$id}";
$result = mysqli_query($connection, $sql);
$staff = mysqli_fetch_assoc($result);

if (!$staff) {
    header("Location: manage-staff.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $staffData = $_POST['staff'];
    $addressData = $_POST['address'];

    // Validate staff details
    if (is_blank($staffData['first_name']) || is_blank($staffData['last_name']) || is_blank($staffData['email']) || is_blank($staffData['phone']) || is_blank($staffData['role'])) {
        $errors[] = "All fields are required";
    }

    if (!has_valid_email_format($staffData['email'])) {
        $errors[] = "Email is invalid";
    }

    if (!is_valid_phone($staffData['phone'])) {
        $errors[] = "Phone number is invalid";
    }

    // Validate address details
    if (is_blank($addressData['address1']) || is_blank($addressData['zip_code'])) {
        $errors[] = "Address fields are required";
    }

    if (empty($errors)) {
        // Update staff
        $sql = "UPDATE staff SET first_name = '{$staffData['first_name']}', last_name = '{$staffData['last_name']}', email = '{$staffData['email']}', phone = '{$staffData['phone']}', role = '{$staffData['role']}' WHERE id = {$id}";
        $result = mysqli_query($connection, $sql);
        
        if ($result) {
            // Update address
            $sql = "UPDATE address SET address1 = '{$addressData['address1']}', address2 = '{$addressData['address2']}', zip_code = '{$addressData['zip_code']}' WHERE id = {$staff['address_id']}";
            $result = mysqli_query($connection, $sql);
            
            if ($result) {
                set_session_message("Staff updated successfully");
                header("Location: manage-staff.php");
                exit;
            } else {
                $errors[] = "Failed to update address";
            }
        } else {
            $errors[] = "Failed to update staff";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>


<div class="container mt-5">
    <h1 class="mb-4 text-center">Edit Staff</h1>
    <p class="mb-4">
        <a href="manage-staff.php" class="link-secondary">Back to Staff Management</a>
    </p>

    <?php echo display_errors($errors); ?>

    <form method="POST" action="edit-staff.php?id=<?php echo $id; ?>">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="staff[first_name]" value="<?php echo htmlspecialchars($staff['first_name']); ?>">
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="staff[last_name]" value="<?php echo htmlspecialchars($staff['last_name']); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="staff[email]" value="<?php echo htmlspecialchars($staff['email']); ?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="number" class="form-control" id="phone" name="staff[phone]" value="<?php echo htmlspecialchars($staff['phone']); ?>">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="staff[role]">
                <option value="headteacher" <?php if ($staff['role'] == 'headteacher') echo 'selected'; ?>>Head Teacher</option>
                <option value="teacher" <?php if ($staff['role'] == 'teacher') echo 'selected'; ?>>Teacher</option>
                <option value="assistant" <?php if ($staff['role'] == 'assistant') echo 'selected'; ?>>Teacher Assistant</option>
                <option value="accountant" <?php if ($staff['role'] == 'accountant') echo 'selected'; ?>>Accountant</option>
                <option value="cleaner" <?php if ($staff['role'] == 'cleaner') echo 'selected'; ?>>Cleaner</option>
            </select>
        </div>

        <h2 class="mt-4">Address Details</h2>
        <div class="mb-3">
            <label for="address1" class="form-label">Address Line 1</label>
            <input type="text" class="form-control" id="address1" name="address[address1]" value="<?php echo htmlspecialchars($staff['address1']); ?>">
        </div>
        <div class="mb-3">
            <label for="address2" class="form-label">Address Line 2</label>
            <input type="text" class="form-control" id="address2" name="address[address2]" value="<?php echo htmlspecialchars($staff['address2']); ?>">
        </div>
        <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zip_code" name="address[zip_code]" value="<?php echo htmlspecialchars($staff['zip_code']); ?>">
        </div>

        <button type="submit" class="btn btn-primary">Update Staff</button>
    </form>
</div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
