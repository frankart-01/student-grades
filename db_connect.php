<?php
$host = 'localhost'; // Hostname (usually 'localhost')
$username = 'root'; // Database username
$password = null; // Database password
$database = 'student_db'; // Database name

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// You are now connected to the database.

// Perform your database operations here...

// Close the database connection when you're done
mysqli_close($conn);
?>
