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
$sql = "SELECT * FROM donors WHERE id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rabd.css">
    <title>User Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>
    </header>
    <main>
        <div class="form-container">
            <h2>Your Information</h2>
            <?php
            if (isset($_SESSION['message'])) {
                echo "<p>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }
            ?>
            <form action="update.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required><br>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $user['age']; ?>" required><br>

                <label for="blood_group">Blood Group:</label>
                <select id="blood_group" name="blood_group" required>
                    <option value="A+" <?php if ($user['blood_group'] == "A+") echo "selected"; ?>>A+</option>
                    <option value="A-" <?php if ($user['blood_group'] == "A-") echo "selected"; ?>>A-</option>
                    <option value="B+" <?php if ($user['blood_group'] == "B+") echo "selected"; ?>>B+</option>
                    <option value="B-" <?php if ($user['blood_group'] == "B-") echo "selected"; ?>>B-</option>
                    <option value="AB+" <?php if ($user['blood_group'] == "AB+") echo "selected"; ?>>AB+</option>
                    <option value="AB-" <?php if ($user['blood_group'] == "AB-") echo "selected"; ?>>AB-</option>
                    <option value="O+" <?php if ($user['blood_group'] == "O+") echo "selected"; ?>>O+</option>
                    <option value="O-" <?php if ($user['blood_group'] == "O-") echo "selected"; ?>>O-</option>
                </select><br>

                <input type="submit" value="Update Information">
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Blood Donation Management System</p>
    </footer>
</body>
</html>
