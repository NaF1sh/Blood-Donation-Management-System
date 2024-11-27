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

if (isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);

    $sql = "UPDATE donors SET name='$name', address='$address', phone='$phone', email='$email', blood_group='$blood_group' WHERE donor_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Donor information updated successfully";
        header("Location: admin_dashboard.php"); 
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
