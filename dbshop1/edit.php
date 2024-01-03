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
    $adopter_id = $_POST['adopter_id'];
    $adopter_name = $_POST['name'];
    $adopter_username = $_POST['username'];
    $adopter_email = $_POST['email'];
    $adopter_phone = $_POST['phone'];
    $adopter_address = $_POST['address'];
    $adopter_password = $_POST['password'];

    // If password is empty, retrieve the existing password from the database
    if (empty($adopter_password)) {
        $sql_password = "SELECT password FROM adopter WHERE id = $adopter_id";
        $result_password = $connection->query($sql_password);
        if ($result_password->num_rows > 0) {
            $row_password = $result_password->fetch_assoc();
            $adopter_password = $row_password['password'];
        }
    } else {
        $adopter_password = password_hash($adopter_password, PASSWORD_DEFAULT);
    }

    // Use prepared statement to avoid SQL injection
    $sql_update = "UPDATE adopter SET name = ?, username = ?, email = ?, phone = ?, address = ?, password = ? WHERE id = ?";
    $stmt = $connection->prepare($sql_update);
    $stmt->bind_param("ssssssi", $adopter_name, $adopter_username, $adopter_email, $adopter_phone, $adopter_address, $adopter_password, $adopter_id);

    if ($stmt->execute()) {
        header("Location: /dbshop1/index.php"); // Change to the actual path
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopter Information</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            text-align: center;
            display: block;
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Adopter</h2>
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
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" name="password">
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
