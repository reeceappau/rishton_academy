<?php
require_once('../functions/initialize.php');

// Get total salaries
$sql = "SELECT SUM(salary) AS total_salaries FROM salary";
$result = mysqli_query($connection, $sql);
$total_salaries = mysqli_fetch_assoc($result)['total_salaries'];

// Get total expenses
$sql = "SELECT SUM(amount) AS total_expenses FROM expenses";
$result = mysqli_query($connection, $sql);
$total_expenses = mysqli_fetch_assoc($result)['total_expenses'];

// Calculate totals
$total_spent = $total_salaries + $total_expenses;
$salary_percentage = ($total_spent > 0) ? ($total_salaries / $total_spent) * 100 : 0;
$expense_percentage = ($total_spent > 0) ? ($total_expenses / $total_spent) * 100 : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .total-spent {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .percentage {
            font-size: 1.25rem;
            color: #34495e;
        }
        .btn-group {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Finance Overview</h1>
        <div class="total-spent mb-4">
            <span class="text-muted">Total Amount Spent:</span> £<?php echo number_format($total_spent, 2); ?>
        </div>
        <p class="percentage">
            Total Salaries: £<?php echo number_format($total_salaries, 2); ?> (<?php echo round($salary_percentage, 2); ?>%)
        </p>
        <p class="percentage">
            Total Expenses: £<?php echo number_format($total_expenses, 2); ?> (<?php echo round($expense_percentage, 2); ?>%)
        </p>
        <div class="btn-group mt-4">
            <a href="salary.php" class="btn btn-primary">Manage Salaries</a>
            <a href="expenses.php" class="btn btn-secondary">View Expenses</a>
            <a href="add-expense.php" class="btn btn-success">Add Expense</a>
        </div>
    </div>
    <?php include('../shared/footer.php'); ?>
</body>
</html>
