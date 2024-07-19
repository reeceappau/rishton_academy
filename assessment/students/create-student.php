<?php

require_once('../functions/initialize.php');

$sql = "SELECT * FROM class";
$classes = mysqli_query($connection, $sql);


 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $student = $_POST['student'];
    $address = $_POST['address'];
    $parent = $_POST['parent'];

    if(is_blank($student['firstName']) || is_blank($student['lastName']) || is_blank($student['dob']) || is_blank($address['address1']) || is_blank($address['zipCode']) || is_blank($student['class']) || is_blank($parent['firstName']) || is_blank($parent['lastName']) || is_blank($parent['phone']) || is_blank($parent['email'])){
        $errors[] = "All fields are required";
    }

    if(!has_valid_email_format($parent['email'])) {
        $errors[] = "Parent's email is invalid";
    }

    if(!is_valid_phone($parent['phone'])) {
        $errors[] = "Parent's phone number is invalid";
    }

    if(!is_valid_postcode($address['zipCode'])) {
        $errors[] = "Zip code is invalid";
    }

    if (empty($errors)){
        $sql = "INSERT INTO address (address1, address2, zip_code) VALUES ('{$address['address1']}', '{$address['address2']}', '{$address['zipCode']}')";
        $result = mysqli_query($connection, $sql);
        if($result) {
            $address_id = mysqli_insert_id($connection);
            $sql = "INSERT INTO parent (first_name, last_name, phone, email) VALUES ('{$parent['firstName']}', '{$parent['lastName']}', '{$parent['phone']}', '{$parent['email']}')";
            $result = mysqli_query($connection, $sql);
            if($result) {
                $parent_id = mysqli_insert_id($connection);
                $sql = "INSERT INTO student (first_name, last_name, date_of_birth, address_id, parent_id, class_id, medical_notes) VALUES ('{$student['firstName']}', '{$student['lastName']}', '{$student['dob']}', {$address_id}, {$parent_id}, {$student['class']}, '{$student['medicalNotes']}')";
                $result = mysqli_query($connection, $sql);
                if($result) {
                    set_session_message("Student created successfully");
                    header("Location: manage-students.php");
                } else {
                    $errors[] = "Failed to create student";
                }
            } else {
                $errors[] = "Failed to create parent";
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
    <title>Create Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Create Student</h1>
    <p class="mb-4">
        <a href="manage-students.php" class="link-secondary">Back to Student Management</a>
    </p>

    <?php echo display_errors($errors); ?>

    <form method="POST" action="create-student.php">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="student[firstName]" value="<?php echo $student['firstName']; ?>">
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="student[lastName]" value="<?php echo $student['lastName']; ?>">
        </div>
        <div class="mb-3">
            <label for="dateOfBirth" class="form-label">Date of birth</label>
            <input type="date" class="form-control" id="dateOfBirth" name="student[dob]" value="<?php echo $student['phone']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentFirstName" class="form-label">Parent First Name</label>
            <input type="text" class="form-control" id="parentFirstName" name="parent[firstName]" value="<?php echo $address['address1']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentLastName" class="form-label">Parent Last Name</label>
            <input type="text" class="form-control" id="parentLastName" name="parent[lastName]" value="<?php echo $address['address2']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentPhone" class="form-label">Parent Phone</label>
            <input type="number" class="form-control" id="parentPhone" name="parent[phone]" value="<?php echo $address['address2']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentEmail" class="form-label">Parent Email</label>
            <input type="text" class="form-control" id="parentEmail" name="parent[email]" value="<?php echo $address['address2']; ?>">
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
            <label for="class" class="form-label">Class</label>
            <select class="form-select" id="class" name="student[class]">
                <option value="" disabled selected>Select a class</option>
                <?php while($class = $classes->fetch_assoc()){ ?>
                <option value="<?php echo $class['ID'];?>"><?php echo $class['name'];?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="medicalNotes" class="form-label">Medical Notes</label>
            <textarea class="form-control" id="medicalNotes" name="student[medicalNotes]"><?php echo $student['medicalNotes']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Student</button>
    </form>
</div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
