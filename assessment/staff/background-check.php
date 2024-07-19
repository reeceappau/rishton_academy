<?php
require_once('../functions/initialize.php');

// Check if mark as completed is submitted
if (isset($_POST['mark_completed'])) {
    $staff_id = $_POST['staff_id'];

    // Insert a new record into the backgroundCheck table
    $sql = "INSERT INTO backgroundCheck (staff_id, status) VALUES ({$staff_id}, 'complete')";
    mysqli_query($connection, $sql);
}

// Fetch staff without background checks completed
$sql = "SELECT staff.id, staff.first_name, staff.last_name, staff.email, staff.phone, staff.role 
        FROM staff 
        LEFT JOIN backgroundCheck ON staff.id = backgroundCheck.staff_id 
        WHERE backgroundCheck.status IS NULL OR backgroundCheck.status = 'incomplete'";

$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Checks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Staff Without Background Check</h1>
        <form class="d-flex mb-4" onsubmit="event.preventDefault(); filterTable();">
            <input class="form-control me-2" type="search" id="searchInput" placeholder="Search" aria-label="Search" onkeyup="filterTable()">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" id="staffTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($staff = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($staff['email']); ?></td>
                            <td><?php echo htmlspecialchars($staff['phone']); ?></td>
                            <td><?php echo htmlspecialchars($staff['role']); ?></td>
                            <td>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="staff_id" value="<?php echo $staff['id']; ?>">
                                    <button type="submit" name="mark_completed" class="btn btn-success">Mark as Completed</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include('../shared/footer.php'); ?>
    
    <script>
        function filterTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("staffTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip table header
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
</body>
</html>
