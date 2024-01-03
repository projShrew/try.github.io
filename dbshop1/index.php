<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit;
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php"); // Redirect to the login page after logout
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adopter Database</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
<div class="container my-5">
    <h2>List of Adopters</h2>
    <a class="btn btn-primary" href="/dbshop1/employee_create.php" role="button">New Adopter</a>
    <a class="btn btn-danger" href="?logout" role="button">Logout</a> <!-- Add this logout button -->
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "petad";

            // Create connection
            $connection = new mysqli($servername, $username, $password, $database);

            // Check Connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Read all rows from the database table
            $sql = "SELECT * FROM adopter";

            $result = $connection->query($sql);

            if (!$result) {
                die("Invalid query: " . $connection->error);
            }

            // Read data of each row
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['date']}</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/dbshop1/edit.php?aid={$row['id']}'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/dbshop1/delete.php?aid={$row['id']}'>Delete</a>
                    </td>
                </tr>
                ";
            }

            // Close the database connection
            $connection->close();

            
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
