<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = test_input($_POST["username"]);
    $user_password = test_input($_POST["password"]);
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM password WHERE user_name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();
        
        // Directly compare the plain text passwords
        if ($user_password === $stored_password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user_name;
            header("Location: ../index.html");
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location.href = '../login.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid username.'); window.location.href = '../login.html';</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>
