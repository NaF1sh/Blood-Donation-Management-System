<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BDMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$cellphone = $_POST['cellphone'];
$age = $_POST['age'];
$blood_group = $_POST['blood_group'];

$sql = "UPDATE donors SET name='$name', address='$address', phone='$phone', email='$email', cell_phone='$cellphone', age=$age, blood_group='$blood_group' WHERE id='$user_id'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "Information updated successfully";
    header("Location: dashboard.php");
} else {
    $_SESSION['message'] = "Error updating information: " . $conn->error;
    header("Location: dashboard.php");
}

$conn->close();
?>
