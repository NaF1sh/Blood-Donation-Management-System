<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BDMS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['login_email']) && !empty($_POST['login_password'])) {
        $login_email = $_POST['login_email'];
        $login_password = $_POST['login_password'];

        $sql = "SELECT * FROM donors WHERE email='$login_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($login_password, $row['password'])) {
                // Store user information in session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];

                // Redirect to the dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with this email.";
        }
    } else {
        echo "Please fill in both email and password.";
    }
}

// Close connection
$conn->close();
?>
