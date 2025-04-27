<?php
// --- Security: Only allow POST requests ---
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // If not POST, redirect away or show an error
    header("Location: ../index.php"); // Redirect to landing page
    exit;
}

// --- Get and Sanitize Data ---
// Use filter_input for better security than directly accessing $_POST
$club = filter_input(INPUT_POST, 'club', FILTER_SANITIZE_SPECIAL_CHARS);
$idea = filter_input(INPUT_POST, 'idea', FILTER_SANITIZE_SPECIAL_CHARS);
$budget_raw = filter_input(INPUT_POST, 'budget', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$fromEmail = filter_input(INPUT_POST, 'fromEmail', FILTER_VALIDATE_EMAIL);
$toEmail = filter_input(INPUT_POST, 'toEmail', FILTER_VALIDATE_EMAIL);

// Get item details (use FILTER_REQUIRE_ARRAY for arrays)
$itemNames_raw = filter_input(INPUT_POST, 'itemName', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
$itemQuantities_raw = filter_input(INPUT_POST, 'itemquantity', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

// Trim whitespace
$idea = trim($idea ?? ''); // Use null coalescing operator
$club = trim($club ?? 'Not Specified');

// Validate Budget
$budget = ($budget_raw !== false && $budget_raw >= 0) ? $budget_raw : false; // Check if valid float >= 0

// --- Basic Validation Check ---
$errors = [];
if (empty($idea)) $errors[] = 'Idea/Proposal is required.';
if ($budget === false) $errors[] = 'Invalid budget amount.';
if (empty($fromEmail)) $errors[] = 'Submitter email is invalid or missing.';
if (empty($toEmail)) $errors[] = 'Recipient email is invalid or missing.';
if (empty($itemNames_raw) || empty($itemQuantities_raw)) $errors[] = 'At least one item is required.';

if (!empty($errors)) {
    // Redirect back with a generic error for simplicity, or pass specific errors via session flash messages later
    header("Location: ../dashboard.php?error=proposal_missing_fields"); // Use the specific error code
    exit;
}

// --- Process Items ---
$items_data = [];
if (is_array($itemNames_raw) && is_array($itemQuantities_raw) && count($itemNames_raw) === count($itemQuantities_raw)) {
    for ($i = 0; $i < count($itemNames_raw); $i++) {
        $name = trim($itemNames_raw[$i]);
        $quantity = $itemQuantities_raw[$i]; // Already validated as INT
        if (!empty($name) && $quantity !== false && $quantity >= 1) {
            $items_data[] = [
                'name' => $name,
                'quantity' => $quantity
            ];
        }
    }
}

if (empty($items_data)) { // Double check if items array ended up empty after filtering
     header("Location: ../dashboard.php?error=proposal_missing_fields"); // Or a specific "invalid_items" error
     exit;
}

$items_json = json_encode($items_data); // Store items as JSON string in DB
if ($items_json === false) {
    // Handle JSON encoding error if necessary (rare)
    error_log("JSON encoding failed for proposal items.");
    header("Location: ../dashboard.php?error=proposal_internal_error");
    exit;
}

// --- Database Connection ---
$db_host = "localhost";
$db_user = "root";
$db_pass = ""; // Your DB password
$db_name = "aryan"; // DB for proposal data

// Use mysqli with error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $con = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $con->set_charset("utf8mb4"); // Recommended for modern character sets
} catch (mysqli_sql_exception $e) {
    error_log("Database connection failed: " . $e->getMessage()); // Log detailed error
    header("Location: ../dashboard.php?error=proposal_db_connect");
    exit;
}

// --- Prepare and Execute Insert Statement ---
// Ensure your table 'data23' matches these columns and types
$sql = "INSERT INTO data23 (club, idea, budget, items, fromEmail, toEmail) VALUES (?, ?, ?, ?, ?, ?)";

try {
    $stmt = $con->prepare($sql);
    // Adjust bind_param types: s=string, d=double/float, i=integer
    $stmt->bind_param("ssdsss", $club, $idea, $budget, $items_json, $fromEmail, $toEmail);
    $stmt->execute();

    // Success: Redirect back to dashboard with success message
    $stmt->close();
    $con->close();
    header("Location: ../dashboard.php?success=proposal_submitted");
    exit;

} catch (mysqli_sql_exception $e) {
    error_log("Error inserting proposal: " . $e->getMessage()); // Log detailed error
    $stmt->close(); // Ensure statement is closed even on error
    $con->close();
    header("Location: ../dashboard.php?error=proposal_db_execute"); // Redirect with specific error
    exit;
}

?>