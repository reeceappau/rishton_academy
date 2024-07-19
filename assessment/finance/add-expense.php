<?php
require_once('../functions/initialize.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $expense = $_POST['expense'];

    if (is_blank($expense['amount']) || is_blank($expense['description'])) {
        $errors[] = "All fields are required";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO expenses (amount, description) VALUES ({$expense['amount']}, '{$expense['description']}')";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            set_session_message("Expense added successfully");
            header("Location: expenses.php");
        } else {
            $errors[] = "Failed to add expense";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Add Expense</h1>
    <a href="expenses.php" class="mb-4 d-block">Back to Manage Expenses</a>
    <?php echo display_errors($errors); ?>
    <form method="POST" action="add-expense.php">
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="expense[description]" placeholder="Enter description">
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="expense[amount]" placeholder="Enter amount">
        </div>
        <button type="submit" class="btn btn-primary">Add Expense</button>
    </form>
</div>
    <?php include('../shared/footer.php'); ?>
</body>
</html>
