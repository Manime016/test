<?php
// Database connection
$servername = "localhost";
$username = "mani";
$password = "Mani789@axl";
$dbname = "flightinfo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to update the "search" table
function updateSearchTable($conn, $selectedAttribute, $attributeValue, $condition) {
    $sql = "UPDATE search SET $selectedAttribute = ? WHERE Flight_No = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $attributeValue, $condition);
    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>alert('Record updated successfully.'); window.location.href='../admin.html';</script>";
        exit();
    } else {
        $stmt->close();
        header("Location: ../admin.html?error=invalid_entry");
        exit();
    }
}

// Function to update the "explore" table
function updateExploreTable($conn, $selectedAttribute, $attributeValue, $condition) {
    $sql = "UPDATE explore SET $selectedAttribute = ? WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $attributeValue, $condition);
    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>alert('Record updated successfully.'); window.location.href='../admin.html';</script>";
        exit();
    } else {
        $stmt->close();
        header("Location: ../admin.html?error=invalid_entry");
        exit();
    }
}

// Check which form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['attributes']) && !empty($_POST['attributes']) && isset($_POST['selectedAttributeValue']) && isset($_POST['condition'])) {
        // Form 1: Update "search" table
        $selectedAttribute = $_POST['attributes'][0];
        $attributeValue = $_POST['selectedAttributeValue'];
        $condition = $_POST['condition'];
        updateSearchTable($conn, $selectedAttribute, $attributeValue, $condition);
    } elseif (isset($_POST['attributes']) && !empty($_POST['attributes']) && isset($_POST['selectedAttributeValue1']) && isset($_POST['condition1'])) {
        // Form 2: Update "explore" table
        $selectedAttribute = $_POST['attributes'][0];
        $attributeValue = $_POST['selectedAttributeValue1'];
        $condition = $_POST['condition1'];
        updateExploreTable($conn, $selectedAttribute, $attributeValue, $condition);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        // Handle delete logic here if needed
        echo "Delete functionality not yet implemented.";
    } else {
        header("Location: ../admin.html?error=invalid_entry");
        exit();
    }
}

$conn->close();
?>
