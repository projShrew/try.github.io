<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "petad";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$adopter_id = "";
$adopter_name = "";
$adopter_username = "";
$adopter_email = "";
$adopter_phone = "";
$adopter_address = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $adopter_id = $_GET['id'];

        $sql = "SELECT * FROM adopter WHERE id = $adopter_id";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $adopter_name = $row['name'];
            $adopter_username = $row['username'];
            $adopter_email = $row['email'];
            $adopter_phone = $row['phone'];
            $adopter_address = $row['address'];
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adopter_name = $_POST['name'];
    $adopter_username = $_POST['username'];
    $adopter_email = $_POST['email'];
    $adopter_phone = $_POST['phone'];
    $adopter_address = $_POST['address'];

    if (!empty($adopter_id)) {
        $sql = "UPDATE adopter SET name = '$adopter_name', username = '$adopter_username', email = '$adopter_email', phone = '$adopter_phone', address = '$adopter_address' WHERE id = $adopter_id";
    } else {
        $sql = "INSERT INTO adopter (name, username, email, phone, address) VALUES ('$adopter_name', '$adopter_username', '$adopter_email', '$adopter_phone', '$adopter_address')";
    }

    if ($connection->query($sql) === TRUE) {
        header("Location: /dbshop1/index.php"); // Change to the actual path
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopter Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2><?php echo (empty($adopter_id) ? 'New Adopter' : 'Edit Adopter'); ?></h2>
        <form method="post">
            <input type="hidden" name="adopter_id" value="<?php echo $adopter_id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $adopter_name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="username" value="<?php echo $adopter_username; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $adopter_email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $adopter_phone; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $adopter_address; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/dbshop1/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
