<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $con = new mysqli("localhost", "root", "", "test");

    if ($con->connect_error) {
        die("Failed to connect: " . $con->connect_error);
    }

    $stmt = $con->prepare("INSERT INTO registration (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        echo "<h2>Data inserted successfully</h2>";
    } else {
        echo "<h2>Error inserting data: " . $stmt->error . "</h2>";
    }

    $stmt->close();
    $con->close();
}
?>


<!-- INSERT INTO `data23` (`Idea_Proposal`, `Required_Budget`) VALUES ('i want to buy a pen atab .', '10000'); -->     