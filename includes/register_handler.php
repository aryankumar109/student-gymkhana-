<?php

// Check if form data exists
if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirm_password']) ||
    empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password']) ) {
    header("Location: ../register.php?error=missing");
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Basic Validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     header("Location: ../register.php?error=invalid_email");
     exit;
}

if ($password !== $confirm_password) {
    header("Location: ../register.php?error=password_mismatch");
    exit;
}

// --- Password Hashing (CRITICAL) ---
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
if ($hashed_password === false) {
     // Log error
     header("Location: ../register.php?error=hash_error");
     exit;
}

// --- Database Connection ---
$db_host = "localhost";
$db_user = "root";
$db_pass = ""; // Your database password
$db_name = "test";

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($con->connect_error) {
    // error_log("Database connection failed: " . $con->connect_error);
    header("Location: ../register.php?error=dberror");
    exit;
}

// --- Check if email already exists ---
$stmt_check = $con->prepare("SELECT email FROM registration WHERE email = ?");
if($stmt_check === false) {
    header("Location: ../register.php?error=dberror"); exit;
}
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result(); // Store result to check num_rows

if ($stmt_check->num_rows > 0) {
    // Email already exists
    $stmt_check->close();
    $con->close();
    header("Location: ../register.php?error=exists");
    exit;
}
$stmt_check->close();


// --- Prepare Insert Statement ---
// Store the HASHED password, not the plain one
$stmt_insert = $con->prepare("INSERT INTO registration (email, password) VALUES (?, ?)");
if($stmt_insert === false) {
    header("Location: ../register.php?error=dberror"); exit;
}

// Bind the email and the HASHED password
$stmt_insert->bind_param("ss", $email, $hashed_password);

if ($stmt_insert->execute()) {
    // Success - Redirect to login page with a success message
    $stmt_insert->close();
    $con->close();
    header("Location: ../login.php?success=registered");
    exit;
} else {
    // Error during insertion
    // error_log("Error inserting data: " . $stmt_insert->error);
    $stmt_insert->close();
    $con->close();
    header("Location: ../register.php?error=dberror"); // Generic error
    exit;
}

?>