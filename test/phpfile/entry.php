<?php
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

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle insert into search table
    if (isset($_POST['sl_No']) && isset($_POST['Flight_No'])) {
        $sl_No = $_POST['sl_No'];
        $Flight_No = $_POST['Flight_No'];
        $Flight_name = $_POST['Flight_name'];
        $Departure_from = $_POST['Departure_from'];
        $Destination = $_POST['Destination'];
        $Departure_time = $_POST['Departure_time'];
        $Booking_Link = $_POST['Booking_Link'];
        $Date = $_POST['Date'];

        $sql = "INSERT INTO search (sl_No, Flight_No, Flight_name, Departure_from, Destination, Departure_time, Booking_Link, Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssss", $sl_No, $Flight_No, $Flight_name, $Departure_from, $Destination, $Departure_time, $Booking_Link, $Date);

        if ($stmt->execute()) {
            $success = true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }
    // Handle insert into explore table
    elseif (isset($_POST['name']) && isset($_POST['info'])) {
        $name = $_POST['name'];
        $info = $_POST['info'];
        $link = $_POST['link'];
        $image = $_POST['image'];
        $slno = $_POST['slno'];

        $sql = "INSERT INTO explore (name, info, link, image, slno) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $info, $link, $image, $slno);

        if ($stmt->execute()) {
            $success = true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }
    // Handle delete action for both tables
    else {
        $condition = isset($_POST['condition1']) ? $_POST['condition1'] : '';

        // Delete from both tables
        $sql1 = "DELETE FROM search WHERE Flight_No = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $condition);
        if ($stmt1->execute()) {
            echo "Record deleted successfully from search table.";
            $success = true;
        } else {
            echo "Error deleting record from search table: " . $stmt1->error;
        }
        $stmt1->close();

        $sql2 = "DELETE FROM explore WHERE name = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $condition);
        if ($stmt2->execute()) {
            echo "Record deleted successfully from explore table.";
            $success = true;
        } else {
            echo "Error deleting record from explore table: " . $stmt2->error;
        }
        $stmt2->close();
    }
}

$conn->close();

if ($success) {
    header("Location: ../admin.html?status=success");
    exit();
} else {
    header("Location: ../admin.html?status=error");
    exit();
}
?>
