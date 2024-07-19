<?php
require_once('../functions/initialize.php');

$sql = "SELECT * FROM staff";
$result = mysqli_query($connection, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>


<div class="container mt-5">
    <?php echo display_session_message(); ?>
    <h1 class="mb-4 text-center">Staff Management</h1>
    <div class="mb-3">
        <a href="create-staff.php" class="btn btn-primary">Create New Staff</a>
    </div>
    <div class="mb-4">
        <input type="text" class="form-control" id="searchInput" placeholder="Search staff..." onkeyup="filterTable()">
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="staffTable">
            <?php  while($staff = $result->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo("{$staff['first_name']} {$staff['last_name']}"); ?></td>
                    <td><?php echo $staff['email']; ?></td>
                    <td><?php echo $staff['role']; ?></td>
                    <td>
                        <a href="edit-staff.php?id=<?php echo $staff['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-staff.php?id=<?php echo $staff['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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
        const table = document.getElementById("staffTable");
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
