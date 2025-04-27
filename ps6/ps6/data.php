<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idea = $_POST['idea'];
    $budget= $_POST['budget'];

    $con = new mysqli("localhost", "root", "", "aryan");

    if ($con->connect_error) {
        die("Failed to connect: " . $con->connect_error);
    }

    $stmt = $con->prepare("INSERT INTO data23 (idea, budget) VALUES (?, ?)");
    $stmt->bind_param("ss", $idea, $budget);

    if ($stmt->execute()) {
        echo "<h2>Data inserted successfully</h2>";
    } else {
        echo "<h2>Error inserting data: " . $stmt->error . "</h2>";
    }

    $stmt->close();
    $con->close();
}
?>

