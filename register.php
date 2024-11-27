<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BDMS";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database.<br>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Form submitted<br>";
    
    if (!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['phone']) &&
        !empty($_POST['email']) && !empty($_POST['age']) && !empty($_POST['blood_group']) &&
        !empty($_POST['password']) && !empty($_POST['confirm_password'])) {

        echo "All required fields are filled.<br>";

        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $blood_group = $_POST['blood_group'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];


        if ($password !== $confirm_password) {
            echo "Passwords do not match!";
            exit();
        }

        echo "Passwords match.<br>";

        $check_sql = "SELECT * FROM donors WHERE email='$email' OR phone='$phone'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            echo "Email or phone number already exists!";
            exit();
        }


        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $sql = "INSERT INTO donors (name, address, phone, email, age, blood_group, password) 
                VALUES ('$name', '$address', '$phone', '$email', '$age', '$blood_group', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Registration successful! Redirecting to dashboard...</p>";
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_name'] = $name; 
            echo "<script>setTimeout(function(){ window.location.href = 'dashboard.php'; }, 3000);</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please fill in all required fields.";
    }
} else {
    echo "Form not submitted correctly.";
}
$conn->close();
?>


