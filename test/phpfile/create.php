<?php
// Start the session
session_start();

$servername = "localhost";
$username = "mani";
$password = "Mani789@axl";
$dbname = "flightinfo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $phone_no = test_input($_POST["phone_no"]);
    $user_name = test_input($_POST["user_name"]);
    $user_password = test_input($_POST["password"]);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO password (name, phone_no, user_name, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone_no, $user_name, $user_password);
    
    // Execute the query
    if ($stmt->execute()) {
        // Redirect to login.html on successful insertion
        header("Location: ../login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>