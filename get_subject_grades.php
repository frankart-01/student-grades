<?php
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = null;
$database = 'student_db';

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the selected subject from the AJAX request
$selectedSubject = $_POST['subject'];

// Query to retrieve subject-specific grades
$query = "SELECT s.FirstName, s.IndexNumber, g.Grade
          FROM students s
          LEFT JOIN grades g ON s.ID = g.StudentID
          WHERE g.SubjectName = '$selectedSubject'";

$result = mysqli_query($conn, $query);

$grades = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $grades[] = $row;
    }
}

// Close the database connection
mysqli_close($conn);

// Return grades in JSON format
header('Content-Type: application/json');
echo json_encode($grades);
?>
