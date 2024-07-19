<?php
require_once('../functions/initialize.php');

$sql = "SELECT salary.salary, staff.id, staff.first_name, staff.last_name, staff.email, staff.role
FROM salary
JOIN staff ON salary.staff_id = staff.id;";
$assigned_salaries = mysqli_query($connection, $sql);

$sql = "SELECT staff.id, staff.first_name, staff.last_name, staff.role
FROM staff
LEFT JOIN salary ON staff.id = salary.staff_id
WHERE salary.salary IS NULL;";
$unassigned_salaries = mysqli_query($connection, $sql);
$number_of_unassigned_salaries = mysqli_num_rows($unassigned_salaries);

$sql = "SELECT SUM(salary) AS total_salaries FROM salary";
$result = mysqli_query($connection, $sql);
$total_salaries = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
    <div class="container mt-5">
    <?php echo display_session_message(); ?>
        <h1 class="mb-4">Salary Management</h1>
        <div class="mb-4">
            <p><b>Total Salaries:</b> £<span id="total-salaries"><?php echo $total_salaries['total_salaries']; ?></span></p>
            <p><b>Unassigned Salaries:</b> <span id="unassigned-count"><?php echo $number_of_unassigned_salaries; ?></span></p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2 class="h4">Unassigned Salaries</h2>
                <?php 
                if ($number_of_unassigned_salaries == 0) {
                    echo "<p>No unassigned salaries</p>";
                } else {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example row -->
                            <?php while($staff = $unassigned_salaries->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo("{$staff['first_name']} {$staff['last_name']}"); ?></td>
                                <td><?php echo $staff['role']; ?></td>
                                <td>
                                    <a href="set-salary.php?id=<?php echo $staff['id']; ?>" class="btn btn-primary">Set Salary</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <!-- Repeat for other unassigned salaries -->
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
            <div class="col-md-8">
                <h2 class="h4">Assigned Salaries</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example row -->
                            <?php while($staff = $assigned_salaries->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo("{$staff['first_name']} {$staff['last_name']}"); ?></td>
                                <td><?php echo $staff['email']; ?></td>
                                <td><?php echo $staff['role']; ?></td>
                                <td>£<?php echo $staff['salary']; ?></td>
                                <td>
                                    <a href="set-salary.php?id=<?php echo $staff['id']; ?>" class="btn btn-secondary">Edit Salary</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <!-- Repeat for other assigned salaries -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include('../shared/footer.php'); ?>
</body>
</html>
