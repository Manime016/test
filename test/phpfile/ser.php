<?php
// Database configuration
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

// Check if "place" is set in $_POST
if(isset($_POST['place'])) {
    $place = $_POST['place'];

    // Prepare and execute the SQL query for explore table
    $sql_explore = $conn->prepare("SELECT name, info, link, image FROM explore WHERE name LIKE ?");
    $searchTerm = "%" . $place . "%";
    $sql_explore->bind_param("s", $searchTerm);
    $sql_explore->execute();
    $result_explore = $sql_explore->get_result();

    // Display the results from explore table
    if ($result_explore->num_rows > 0) {
        echo "<h2>Search Results for '$place' in explore:</h2>";
        while ($row = $result_explore->fetch_assoc()) {
            echo "<div class='result'>";
            echo "<h3>" . $row["name"] . "</h3>";
            echo "<p>" . $row["info"] . "</p>";
            echo "<a href='" . $row["link"] . "'>More Info</a>";
            echo "<br><img src='" . $row["image"] . "' alt='" . $row["name"] . "' width='200'>";
            echo "</div>";
        }
    } else {
        echo "<p>No results found for '$place' in explore</p>";
    }
} else if(isset($_POST['from']) && isset($_POST['to'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    // Prepare and execute the SQL query for search table
    $sql_search = "SELECT * FROM search WHERE Departure_from = '$from' AND Destination = '$to'";
    $result_search = $conn->query($sql_search);

    // Display the results from search table
    if ($result_search->num_rows > 0) {
        echo "<table><tr><th>Sl No</th><th>Flight No</th><th>Flight Name</th><th>Departure From</th><th>Destination</th><th>Departure Time</th><th>Booking Link</th></tr>";
        while($row = $result_search->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["sl_No"]. "</td>";
            echo "<td>" . $row["Flight_No"]. "</td>";
            echo "<td>" . $row["Flight_name"]. "</td>";
            echo "<td>" . $row["Departure_from"]. "</td>";
            echo "<td>" . $row["Destination"]. "</td>";
            echo "<td>" . $row["Departure_time"]. "</td>";
            echo "<td><a href='" . $row["Booking_Link"]. "'>Book Now</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No flights found from '$from' to '$to'";
    }
} else {
    echo "Please provide either 'place' parameter for explore or both 'from' and 'to' parameters for search.";
}

// Close the connection
$conn->close();
?>
