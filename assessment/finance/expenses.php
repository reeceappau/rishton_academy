<?php
require_once('../functions/initialize.php');

$sql = "SELECT * FROM expenses";
$expenses = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Expenses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
<div class="container mt-5">
    <?php echo display_session_message(); ?>
    <h1 class="mb-4">Manage Expenses</h1>
    <div class="mb-4">
        <a href="add-expense.php" class="btn btn-success">Add New Expense</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($expense = mysqli_fetch_assoc($expenses)) { ?>
                <tr>
                    <td><?php echo $expense['description']; ?></td>
                    <td>£<?php echo $expense['amount']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
    <?php include('../shared/footer.php'); ?>
</body>
</html>
