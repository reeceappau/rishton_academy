<?php

require_once('../functions/initialize.php');

if (!isset($_GET['id'])) {
    header("Location: manage-students.php");
} 

$id = $_GET['id']; 

$sql = "SELECT * FROM class";
$classes = mysqli_query($connection, $sql);


$sql = " SELECT 
        student.id,
        student.first_name,
        student.last_name,
        student.date_of_birth,
        student.parent_id,
        student.address_id,
        class.name AS class_name,
        parent.first_name AS parent_first_name,
        parent.last_name AS parent_last_name,
        parent.email,
        parent.phone,
        address.address1,
        address.address2,
        address.zip_code
    FROM 
        student
    LEFT JOIN 
        class ON student.class_id = class.id
    LEFT JOIN 
        parent ON student.parent_id = parent.id
    LEFT JOIN 
        address ON student.address_id = address.id
    WHERE 
        student.id = {$id};
";
$result = mysqli_query($connection, $sql);
$student = mysqli_fetch_assoc($result);


if (!$student) {
    header("Location: manage-students.php");
}


 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $parent_id = $student['parent_id'];
    $address_id = $student['address_id'];
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
        // Update address
        $sql = "UPDATE address 
                SET address1 = '{$address['address1']}', 
                    address2 = '{$address['address2']}', 
                    zip_code = '{$address['zipCode']}' 
                WHERE id = {$address_id}";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            // Update parent
            $sql = "UPDATE parent 
                    SET first_name = '{$parent['firstName']}', 
                        last_name = '{$parent['lastName']}', 
                        phone = '{$parent['phone']}', 
                        email = '{$parent['email']}' 
                    WHERE id = {$parent_id}";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                // Update student
                $sql = "UPDATE student 
                        SET first_name = '{$student['firstName']}', 
                            last_name = '{$student['lastName']}', 
                            date_of_birth = '{$student['dob']}', 
                            class_id = {$student['class']}, 
                            medical_notes = '{$student['medicalNotes']}' 
                        WHERE id = {$id}";
                $result = mysqli_query($connection, $sql);
                if ($result) {
                    set_session_message("Student updated successfully");
                    header("Location: manage-students.php");
                } else {
                    $errors[] = "Failed to update student";
                }
            } else {
                $errors[] = "Failed to update parent";
            }
        } else {
            $errors[] = "Failed to update address";
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
    <h1 class="mb-4 text-center">Edit Student</h1>
    <p class="mb-4">
        <a href="manage-students.php" class="link-secondary">Back to Student Management</a>
    </p>

    <?php echo display_errors($errors); ?>

    <form method="POST" action="edit-student.php?id=<?php echo $id; ?>">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="student[firstName]" value="<?php echo $student['first_name']; ?>">
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="student[lastName]" value="<?php echo $student['last_name']; ?>">
        </div>
        <div class="mb-3">
            <label for="dateOfBirth" class="form-label">Date of birth</label>
            <input type="date" class="form-control" id="dateOfBirth" name="student[dob]" value="<?php echo $student['date_of_birth']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentFirstName" class="form-label">Parent First Name</label>
            <input type="text" class="form-control" id="parentFirstName" name="parent[firstName]" value="<?php echo $student['parent_first_name']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentLastName" class="form-label">Parent Last Name</label>
            <input type="text" class="form-control" id="parentLastName" name="parent[lastName]" value="<?php echo $student['parent_last_name']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentPhone" class="form-label">Parent Phone</label>
            <input type="number" class="form-control" id="parentPhone" name="parent[phone]" value="<?php echo $student['phone']; ?>">
        </div>
        <div class="mb-3">
            <label for="parentEmail" class="form-label">Parent Email</label>
            <input type="text" class="form-control" id="parentEmail" name="parent[email]" value="<?php echo $student['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="address1" class="form-label">Address Line 1</label>
            <input type="text" class="form-control" id="address1" name="address[address1]" value="<?php echo $student['address1']; ?>">
        </div>
        <div class="mb-3">
            <label for="address2" class="form-label">Address Line 2</label>
            <input type="text" class="form-control" id="address2" name="address[address2]" value="<?php echo $student['address2']; ?>">
        </div>
        <div class="mb-3">
            <label for="zipCode" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zipCode" name="address[zipCode]" value="<?php echo $student['zip_code']; ?>">
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
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
