<?php
require_once('../functions/initialize.php');

$sql = "SELECT * FROM class";
$classes = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .card-link:hover .card {
            box-shadow: 0 0 11px rgba(33, 33, 33, .2);
        }
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        .card-text {
            font-size: 1rem;
            font-weight: bold;
            color: #6c757d;
        }
        .card-img {
            width: 80px; /* Increased image size */
            height: 80px;
            object-fit: cover;
            margin-right: 15px; /* Space between image and text */
        }
        .card-body {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php include('../shared/navbar.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Classes</h1>
        
    <div class="row">
    <?php 
        $imageCounter = 0; // Initialize an image counter
        while($class = mysqli_fetch_assoc($classes)) { ?>
            <div class="col-md-4 mb-4">
                <a href="view-class.php?id=<?php echo $class['ID']; ?>" class="card-link">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <img src="/assessment/images/<?php echo $imageCounter; ?>.png" class="card-img mr-3" alt="Students" style="width: 50px; height: auto;">
                            <h5 class="card-title mb-0"><?php echo $class['name']; ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php 
            $imageCounter++; // Increment the counter
        } 
    ?>
    </div>
</div>
    <?php include('../shared/footer.php'); ?>
</body>
</html>
