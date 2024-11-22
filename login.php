<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BDMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['login_email'];
$password = $_POST['login_password'];

$sql = "SELECT * FROM donors WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid password";
    }
} else {
    echo "No user found with this email";
}

$conn->close();
?>
