<?php

require_once('../functions/initialize.php');

if (!isset($_GET['id'])) {
    header("Location: manage-students.php");
    exit;
}

$id = $_GET['id'];

$sql = " SELECT 
        student.id,
        student.first_name,
        student.last_name,
        student.date_of_birth,
        student.medical_notes,
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
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .student-details {
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .student-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include('../shared/navbar.php'); ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Student Details</h1>
    <p class="mb-4">
        <a href="manage-students.php" class="link-secondary">Back to Student Management</a>
    </p>

    <div class="student-details">
        <div class="row">
            <div class="col-md-12">
                <p class="student-name"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($student['date_of_birth']); ?></p>
                <p><strong>Class:</strong> <?php echo htmlspecialchars($student['class_name']); ?></p>
                <p><strong>Medical Notes:</strong> <?php echo htmlspecialchars($student['medical_notes']); ?></p>
                <hr>
                <div class="section-title">Parent Details</div>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($student['parent_first_name'] . ' ' . $student['parent_last_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($student['phone']); ?></p>
                <hr>
                <div class="section-title">Address</div>
                <p><strong>Address Line 1:</strong> <?php echo htmlspecialchars($student['address1']); ?></p>
                <p><strong>Address Line 2:</strong> <?php echo htmlspecialchars($student['address2']); ?></p>
                <p><strong>Zip Code:</strong> <?php echo htmlspecialchars($student['zip_code']); ?></p>
            </div>
        </div>
    </div>
</div>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
