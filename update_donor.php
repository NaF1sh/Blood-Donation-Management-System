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
    $id = $_POST['id'];

    $sql = "SELECT donor_id, name, address, phone, email, blood_group FROM donors WHERE donor_id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>Update Donor</title>
        </head>
        <body>
            <div class="container">
                <h1>Update Donor</h1>
                <form action="save_donor.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['donor_id']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required><br>
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br>
                    <label for="blood_group">Blood Group:</label>
                    <select id="blood_group" name="blood_group" required>
                        <option value="A+" <?php if ($row['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                        <option value="A-" <?php if ($row['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                        <option value="B+" <?php if ($row['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                        <option value="B-" <?php if ($row['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                        <option value="AB+" <?php if ($row['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                        <option value="AB-" <?php if ($row['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                        <option value="O+" <?php if ($row['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                        <option value="O-" <?php if ($row['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
                    </select><br>
                    <input type="submit" value="Save Changes">
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Donor not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
