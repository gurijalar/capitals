<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "states_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure 'state' is passed in the POST request
if (isset($_POST['state'])) {
    $state = $_POST['state'];
    
    // Prepare and execute SQL query to fetch capital for the selected state
    $sql = "SELECT capital_name FROM states WHERE state_name = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $state); // Bind the state name to the query
        $stmt->execute(); // Execute the query
        $stmt->bind_result($capital); // Bind the result to the capital variable
        $stmt->fetch(); // Fetch the result
        
        // Display the result or a message if no match is found
        if ($capital) {
            echo "<p>The capital of " . htmlspecialchars($state) . " is " . htmlspecialchars($capital) . ".</p>";
        } else {
            echo "<p>State not found in the database.</p>";
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL query: " . $conn->error;
    }
} else {
    echo "No state selected.";
}

$conn->close();
?>
