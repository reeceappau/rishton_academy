<?php
session_start();

// Initialize variables
$pin = "";
$error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Define your valid PIN here
    $valid_pin = "1234"; // Replace with your actual PIN

    // Get PIN input from form
    $pin = $_POST['pin'];

    // Validate PIN
    if ($pin == $valid_pin) {
        // PIN is correct, set session variable
        $_SESSION['loggedin'] = true;
        
        // Redirect to index page
        header("Location: index.php");
        exit;
    } else {
        // PIN is incorrect, set error message
        $error = "Invalid PIN. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2 class="text-center mb-4">Login</h2>
    <p class="text-center mb-4">Enter the portal PIN to log in</p>
    <?php if ($error): ?>
      <div class="alert alert-danger mb-3" role="alert"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
        <label for="pin">PIN:</label>
        <input type="password" class="form-control" id="pin" name="pin" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
  </div>

  <!-- Bootstrap JS and dependencies (optional if you need JS functionality) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
