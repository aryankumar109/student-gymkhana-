<?php
session_start(); // Start session to potentially store login state later
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"> <!-- Link the combined style -->
</head>
<body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <div class="col-md-6 col-lg-5 col-xl-4 mx-auto"> <!-- Responsive column for centering -->
                <div class="card shadow-lg auth-card"> <!-- Added shadow and auth-card class -->
                    <div class="card-header text-center text-white">
                        <h2>Student Gymkhana Login</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        // Display error messages if they exist in the URL
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            echo '<div class="alert alert-danger" role="alert">';
                            if ($error == 'invalid') {
                                echo 'Invalid email or password.';
                            } elseif ($error == 'missing') {
                                echo 'Please fill in both email and password.';
                            } else {
                                echo 'An unknown error occurred.';
                            }
                            echo '</div>';
                        }
                        // Display success message (e.g., after registration)
                         if (isset($_GET['success']) && $_GET['success'] == 'registered') {
                            echo '<div class="alert alert-success" role="alert">';
                            echo 'Registration successful! Please log in.';
                            echo '</div>';
                        }
                        ?>
                        <form action="includes/login_handler.php" method="post">
                            <div class="form-group mb-3"> <!-- Added margin bottom -->
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control form-control-lg" name="email" required /> <!-- Added required attribute -->
                            </div>
                            <div class="form-group mb-4"> <!-- Added margin bottom -->
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control form-control-lg" name="password" required /> <!-- Added required attribute -->
                            </div>
                            <input type="submit" class="btn btn-primary btn-lg w-100" value="Login"> <!-- Larger button -->
                        </form>
                    </div>
                    <div class="extra-links"> <!-- Div for links -->
                        <a href="forget_pass.php">Forgot Password?</a> | <!-- Updated link -->
                        <a href="register.php">New Registration</a> <!-- Updated link -->
                    </div>
                     <div class="card-footer text-center"> <!-- Centered footer -->
                        <small>© The Crazy Coders</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>