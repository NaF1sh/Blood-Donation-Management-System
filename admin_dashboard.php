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

$admin_username = "admin";
$admin_password_hash = password_hash("admin123", PASSWORD_DEFAULT); 

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] == $admin_username && password_verify($_POST['password'], $admin_password_hash)) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        echo "Invalid credentials";
        exit();
    }
} elseif (!isset($_SESSION['admin_logged_in'])) {
    echo "Please log in.";
    exit();
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM donors WHERE donor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        //echo "Donor deleted successfully.";
    } else {
        //echo "Error deleting donor.";
    }
    $stmt->close();
}



if (isset($_POST['populate_data'])) {
    $sql = "CREATE TABLE IF NOT EXISTS donors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        address VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(255) NOT NULL,
        blood_group VARCHAR(5) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    if ($conn->query($sql) === TRUE) {
        echo "Table donors created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }


    /*$names = ["John Doe", "Jane Smith", "Alice Johnson", "Bob Brown", "Charlie Davis", "Emily White", "David Green", "Susan Blue", "Michael Black", "Nancy Yellow"];
    $addresses = ["123 Main St, Bangladesh", "456 Elm St, Dhaka", "789 Oak St, Chittagong", "101 Pine St, Sylhet", "202 Cedar St, Rajshahi", "303 Maple St, Khulna", "404 Birch St, Barisal", "505 Ash St, Comilla", "606 Cherry St, Mymensingh", "707 Willow St, Noakhali"];
    $phones = ["123-456-7890", "234-567-8901", "345-678-9012", "456-789-0123", "567-890-1234", "678-901-2345", "789-012-3456", "890-123-4567", "901-234-5678", "012-345-6789"];
    $emails = ["john@example.com", "jane@example.com", "alice@example.com", "bob@example.com", "charlie@example.com", "emily@example.com", "david@example.com", "susan@example.com", "michael@example.com", "nancy@example.com"];
    $blood_groups = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];*/
    $num_records = 1000;

    for ($i = 0; $i < $num_records; $i++) {
        $name = $names[array_rand($names)];
        $address = $addresses[array_rand($addresses)];
        $phone = $phones[array_rand($phones)];
        $email = $emails[array_rand($emails)];
        $blood_group = $blood_groups[array_rand($blood_groups)];
        $password = password_hash("password", PASSWORD_DEFAULT);

        $sql = "INSERT INTO donors (name, address, phone, email, blood_group, password)
                VALUES ('$name', '$address', '$phone', '$email', '$blood_group', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    }
}

$sql = "SELECT donor_id, name, address, phone, email, blood_group FROM donors";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admindash_styles.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <h1>Donor List</h1>
    </header>
    <main>
        <?php
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Address</th><th>Phone</th><th>Email</th><th>Blood Group</th><th>Actions</th></tr>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["donor_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["address"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["email"] . "</td><td>" . $row["blood_group"] . "</td>
                      <td>
                        <form action='update_donor.php' method='post' style='display:inline-block;'>
                            <input type='hidden' name='id' value='" . $row["donor_id"] . "'>
                            <input type='submit' value='Edit'>
                        </form>
                        <form action='admin_dashboard.php' method='get' style='display:inline-block;'>
                            <input type='hidden' name='delete_id' value='" . $row["donor_id"] . "'>
                            <input type='submit' value='Delete'>
                        </form>
                      </td></tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No donors found</td></tr>";
        }

        echo "</table>";
        ?>

        <h2>Add New Donor</h2>
        <form action="admin_dashboard.php" method="post">
            <input type="hidden" name="add_donor" value="1">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="blood_group">Blood Group:</label>
            <select id="blood_group" name="blood_group" required>
                <option value='A+'>A+</option>
                <option value='A-'>A-</option>
                <option value='B+'>B+</option>
                <option value='B-'>B-</option>
                <option value='AB+'>AB+</option>
                <option value='AB-'>AB-</option>
                <option value='O+'>O+</option>
                <option value='O-'>O-</option>
            </select><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Add Donor">
        </form>

        <h2>Initialize Database</h2>
        <form action="admin_dashboard.php" method="post">
            <input type="hidden" name="populate_data" value="1">
            <input type="submit" value="Create Table and Populate Data">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Blood Donation Management System</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
