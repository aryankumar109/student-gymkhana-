<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register Account</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"> <!-- Link the combined style -->
    <!-- REMOVED link to register.css -->
</head>
<body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
         <div class="row w-100">
            <div class="col-md-6 col-lg-5 col-xl-4 mx-auto"> <!-- Responsive column for centering -->
                <div class="card shadow-lg auth-card"> <!-- Use same card style as login -->
                     <div class="card-header text-center text-white">
                        <h2>Create Account</h2>
                    </div>
                    <div class="card-body">
                         <?php
                        // Display error messages if they exist in the URL
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            echo '<div class="alert alert-danger" role="alert">';
                            if ($error == 'exists') {
                                echo 'An account with this email already exists.';
                            } elseif ($error == 'dberror') {
                                echo 'Database error. Please try again later.';
                            } elseif ($error == 'missing') {
                                echo 'Please fill in all fields.';
                             } elseif ($error == 'password_mismatch') {
                                echo 'Passwords do not match.';
                            } else {
                                echo 'An registration error occurred.';
                            }
                            echo '</div>';
                        }
                        ?>
                        <form action="includes/register_handler.php" method="post"> <!-- Correct action -->
                            <div class="form-group mb-3">
                                <label for="email">Email Address:</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                            </div>
                             <div class="form-group mb-4">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg w-100">Register</button> <!-- Success button -->
                        </form>
                    </div>
                     <div class="extra-links">
                        <a href="login.php">Already have an account? Login</a>
                    </div>
                     <div class="card-footer text-center">
                        <small>© The Crazy Coders</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>