<?php
// Basic check if data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Get Data (Add more validation as needed) ---
    $club = isset($_POST['club']) ? $_POST['club'] : 'Not Specified'; // Added club
    $idea = isset($_POST['idea']) ? trim($_POST['idea']) : '';
    $budget = isset($_POST['budget']) ? filter_var($_POST['budget'], FILTER_VALIDATE_FLOAT) : 0; // Validate budget
    $fromEmail = isset($_POST['fromEmail']) ? filter_var($_POST['fromEmail'], FILTER_VALIDATE_EMAIL) : '';
    $toEmail = isset($_POST['toEmail']) ? filter_var($_POST['toEmail'], FILTER_VALIDATE_EMAIL) : '';

    // Get item details (assuming they are sent as arrays)
    $itemNames = isset($_POST['itemName']) ? $_POST['itemName'] : [];
    $itemQuantities = isset($_POST['itemquantity']) ? $_POST['itemquantity'] : [];

    // Basic check for required fields
    if (empty($idea) || $budget === false || empty($fromEmail) || empty($toEmail) || empty($itemNames)) {
        // Redirect back with an error - Need a way to show error on thirdpage.php
        header("Location: ../thirdpage.php?error=missing_fields");
        exit;
    }

    // Combine item details into a string or JSON for storage (Example: JSON)
    $items_data = [];
    for ($i = 0; $i < count($itemNames); $i++) {
        if (!empty($itemNames[$i]) && isset($itemQuantities[$i])) {
            $items_data[] = [
                'name' => trim($itemNames[$i]),
                'quantity' => filter_var($itemQuantities[$i], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) ?: 1 // Ensure quantity is valid int >= 1
            ];
        }
    }
    $items_json = json_encode($items_data); // Store items as JSON string in DB

    // --- Database Connection ---
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = ""; // Your database password
    $db_name = "aryan"; // Database for proposal data

    $con = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($con->connect_error) {
        // Redirect back with error
        header("Location: ../thirdpage.php?error=db_connect");
        exit;
    }

    // --- Prepare Statement ---
    // Adjust your table 'data23' to include columns for club, items (e.g., as JSON/TEXT), fromEmail, toEmail
    // Example assuming table `proposals` with columns: club, idea, budget, items_json, submitter_email, recipient_email
    $stmt = $con->prepare("INSERT INTO data23 (club, idea, budget, items, fromEmail, toEmail) VALUES (?, ?, ?, ?, ?, ?)"); // Adjust table and column names
    if ($stmt === false) {
         header("Location: ../thirdpage.php?error=db_prepare"); exit;
    }

    // Adjust bind_param types: s=string, d=double/float, i=integer
    $stmt->bind_param("ssdsss", $club, $idea, $budget, $items_json, $fromEmail, $toEmail); // Adjust types based on your columns

    if ($stmt->execute()) {
        // Success: Redirect back with success message
        $stmt->close();
        $con->close();
        header("Location: ../thirdpage.php?success=proposal_submitted");
        exit;
    } else {
        // Error: Redirect back with error message
        // error_log("Error inserting proposal: " . $stmt->error);
        $stmt->close();
        $con->close();
        header("Location: ../thirdpage.php?error=db_execute");
        exit;
    }

} else {
    // If not POST, redirect away or show error
    header("Location: ../index.php"); // Redirect to homepage if accessed directly
    exit;
}
?>