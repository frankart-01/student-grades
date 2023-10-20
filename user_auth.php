<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <!-- Include Bootstrap 5 CSS from a CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Login</h1>
        <?php
        session_start(); // Start a session to store user data

        // Database connection settings
        $host = 'localhost';
        $username = 'root';
        $password = null;
        $database = 'student_db';

        // Create a database connection
        $conn = mysqli_connect($host, $username, $password, $database);

        // Check if the connection was successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Function to validate and authenticate a user
        function authenticateUser($conn, $username, $password, $userType) {
            $username = mysqli_real_escape_string($conn, $username);
            $password = mysqli_real_escape_string($conn, $password);

            if ($userType === 'admin') {
                // Query the administrators table to check if it's an administrator
                $admin_query = "SELECT * FROM administrators WHERE Username='$username' AND PasswordHash='$password'";
                $admin_result = mysqli_query($conn, $admin_query);

                if (mysqli_num_rows($admin_result) == 1) {
                    // Administrator login successful
                    $_SESSION['user_type'] = 'admin';
                    $_SESSION['username'] = $username;
                                    
                    // Redirect to the admin dashboard
                    header("Location: admin_dashboard.php");
                    exit;
                    
                }
                
            } elseif ($userType === 'student') {
                // Query the students table to check if it's a student
                $student_query = "SELECT * FROM students WHERE IndexNumber='$username'";
                $student_result = mysqli_query($conn, $student_query);

                if (mysqli_num_rows($student_result) == 1) {
                    // Student login successful
                    $_SESSION['user_type'] = 'student';
                    $_SESSION['username'] = $username;
                    return true;
                }
            }
            else{
                echo "<div class='alert alert-danger' role='alert'>Error logging in! Check credentials and try again.</div>"; // Authentication failed
            }
            
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['userType'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $userType = $_POST['userType'];

                if (authenticateUser($conn, $username, $password, $userType)) {
                    // Redirect to the appropriate user page
                    if ($_SESSION['user_type'] === 'admin') {
                        header("Location: admin_dashboard.php");
                    } elseif ($_SESSION['user_type'] === 'student') {
                        header("Location: student_dashboard.php");
                    }
                } else {
                    $error_message = "Invalid username or password.";
                }
            }
        }

        // Close the database connection when done
        mysqli_close($conn);
        ?>

        <form method="post" class="mt-3">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="userType" class="form-label">Select User Type:</label>
                <select name="userType" class="form-select" required>
                    <option value="admin">Administrator</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
