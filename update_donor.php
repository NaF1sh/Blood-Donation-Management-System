<?php
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

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch donor data
    $sql = "SELECT id, name, address, phone, email, blood_group FROM donors WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h1>Update Donor</h1>";
        echo "<form action='save_donor.php' method='post'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <label for='name'>Name:</label>
                <input type='text' id='name' name='name' value='" . $row['name'] . "' required><br>
                <label for='address'>Address:</label>
                <input type='text' id='address' name='address' value='" . $row['address'] . "' required><br>
                <label for='phone'>Phone:</label>
                <input type='tel' id='phone' name='phone' value='" . $row['phone'] . "' required><br>
                <label for='email'>Email:</label>
                <input type='email' id='email' name='email' value='" . $row['email'] . "' required><br>
                <label for='blood_group'>Blood Group:</label>
                <select id='blood_group' name='blood_group' required>
                    <option value='A+' " . ($row['blood_group'] == 'A+' ? 'selected' : '') . ">A+</option>
                    <option value='A-' " . ($row['blood_group'] == 'A-' ? 'selected' : '') . ">A-</option>
                    <option value='B+' " . ($row['blood_group'] == 'B+' ? 'selected' : '') . ">B+</option>
                    <option value='B-' " . ($row['blood_group'] == 'B-' ? 'selected' : '') . ">B-</option>
                    <option value='AB+' " . ($row['blood_group'] == 'AB+' ? 'selected' : '') . ">AB+</option>
                    <option value='AB-' " . ($row['blood_group'] == 'AB-' ? 'selected' : '') . ">AB-</option>
                    <option value='O+' " . ($row['blood_group'] == 'O+' ? 'selected' : '') . ">O+</option>
                    <option value='O-' " . ($row['blood_group'] == 'O-' ? 'selected' : '') . ">O-</option>
                </select><br>
                <input type='submit' value='Save Changes'>
              </form>";
    } else {
        echo "Donor not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
