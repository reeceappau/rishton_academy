<?php include('functions/initialize.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Head Teacher Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-text {
            font-size: 1rem;
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
    <?php include('shared/navbar.php'); ?>

    <div class="container mt-5">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center">
            <img src="/assessment/images/logo.png" height="100" class="mr-3">
            <h1>Rishton Academy Portal</h1>
        </div>
    </div>
    <p class="mb-4">Welcome! Please select one of the following options to manage different aspects of the school.</p>
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="students/manage-students.php" class="card-link">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="/assessment/images/students.png" class="card-img" alt="Students">
                        <div>
                            <h5 class="card-title">Students</h5>
                            <p class="card-text">Oversee and manage student information and activities.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="classes/manage-classes.php" class="card-link">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="/assessment/images/class.png" class="card-img" alt="Classes">
                        <div>
                            <h5 class="card-title">Classes</h5>
                            <p class="card-text">Create, update, and manage class schedules and assignments.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="staff/manage-staff.php" class="card-link">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="/assessment/images/staff.png" class="card-img" alt="Staff">
                        <div>
                            <h5 class="card-title">Staff</h5>
                            <p class="card-text">Handle staff details, roles, and other administrative tasks.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="finance/overview.php" class="card-link">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="/assessment/images/finance.png" class="card-img" alt="Finance">
                        <div>
                            <h5 class="card-title">Finance</h5>
                            <p class="card-text">Manage salaries and expenses.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="staff/background-check.php" class="card-link">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="/assessment/images/background.png" class="card-img" alt="Background Checks">
                        <div>
                            <h5 class="card-title">Background Checks</h5>
                            <p class="card-text">Update background checks of staff.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>


    <?php include('shared/footer.php'); ?>
</body>
</html>

