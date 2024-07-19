<?php
require_once('../functions/initialize.php');

$sql = " SELECT 
student.id,
student.first_name,
student.last_name,
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
address ON student.address_id = address.id;
";
$result = mysqli_query($connection, $sql);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>


<div class="container mt-5">
    <?php echo display_session_message(); ?>
    <h1 class="mb-4 text-center">Student Management</h1>
    <div class="mb-3">
        <a href="create-student.php" class="btn btn-primary">Create New Student</a>
    </div>
    <div class="mb-4">
        <input type="text" class="form-control" id="searchInput" placeholder="Search student..." onkeyup="filterTable()">
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Parent</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="studentTable">
            <?php  while($student = $result->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo("{$student['first_name']} {$student['last_name']}"); ?></td>
                    <td><?php echo $student['class_name']; ?></td>
                    <td><?php echo("{$student['parent_first_name']} {$student['parent_last_name']}"); ?></td>
                    <td><?php echo $student['phone']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td><?php echo("{$student['address1']} {$student['address2']}, {$student['zip_code']}"); ?></td>
                    <td>
                        <a href="view-student.php?id=<?php echo $student['id']; ?>" class="btn btn-primary btn-sm">More</a>
                        <a href="edit-student.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-student.php?id=<?php echo $student['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            <!-- More staff rows as needed -->
        </tbody>
    </table>
</div>

<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("studentTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let found = false;

            for (let j = 0; j < cells.length - 1; j++) { // Exclude actions column
                if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                }
            }
            rows[i].style.display = found ? "" : "none";
        }
    }
</script>

    <?php include('../shared/footer.php'); ?>
</body>
</html>
