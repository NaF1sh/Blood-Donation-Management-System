<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lfb.css">
    <title>Blood Donation Results</title>
</head>
<body>
<header>
    <button onclick="location.href='index.html'" class="home-button">Back to Home</button>
    <h1>Blood Donation Results</h1>
</header>
<main>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BDMS";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$blood_group = $conn->real_escape_string($_POST['blood_group']);
$location = $conn->real_escape_string($_POST['location']);


echo "Blood Group: " . htmlspecialchars($blood_group) . "<br>";
echo "Location: " . htmlspecialchars($location) . "<br>";


$sql = "SELECT name, phone, email FROM donors WHERE blood_group='$blood_group' AND address LIKE '%$location%'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>Name: " . htmlspecialchars($row["name"]) . "<br> Phone: " . htmlspecialchars($row["phone"]) . "<br> Email: " . htmlspecialchars($row["email"]) . "</li>";
    }
    echo "</ul>";
} else {
    echo "No matching blood donations found.";
}

$conn->close();
?>
</main>
<footer>
    <p>&copy; 2024 Blood Donation Management System</p>
</footer>
</body>
</html>
