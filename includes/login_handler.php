<?php
session_start(); // Start session potentially

// Check if form data exists
if (!isset($_POST['email']) || !isset($_POST['password']) || empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: ../login.php?error=missing"); // Redirect back to login with error
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

// --- Database Connection ---
$db_host = "localhost";
$db_user = "root";
$db_pass = ""; // Your database password
$db_name = "test"; // Database for login/registration

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check Connection
if ($con->connect_error) {
    // Log error instead of dying for better user experience in production
    // error_log("Database connection failed: " . $con->connect_error);
    header("Location: ../login.php?error=dberror"); // Generic DB error
    exit;
}

// --- Prepare Statement to prevent SQL Injection ---
$stmt = $con->prepare("SELECT email, password FROM registration WHERE email = ?");
if ($stmt === false) {
    // error_log("Prepare failed: " . $con->error);
    header("Location: ../login.php?error=dberror");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt_result = $stmt->get_result();

if ($stmt_result->num_rows > 0) {
    $data = $stmt_result->fetch_assoc();

    // --- Verify Password ---
    // !! IMPORTANT: Verify hashed password instead of plain text !!
    if (password_verify($password, $data['password'])) {
        // Password is correct
        $_SESSION['user_email'] = $data['email']; // Example: Store user email in session
        $_SESSION['logged_in'] = true;

        // Redirect to the main page (index.php)
        header("Location: ../dashboard.php"); 
        exit;
    } else {
        // Invalid password
        header("Location: ../login.php?error=invalid");
        exit;
    }
} else {
    // Invalid email (user not found)
    header("Location: ../login.php?error=invalid");
    exit;
}

$stmt->close();
$con->close();

?>