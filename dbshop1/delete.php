<?php
if (isset($_GET["aid"])) {
    $adopter_id = $_GET["aid"];

    // Debug: Output the adopter ID to check if it's being correctly received
    echo "Adopter ID: " . $adopter_id . "<br>";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "petad"; // Change to the actual database name

    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "DELETE FROM adopter WHERE id = $adopter_id";

    if ($connection->query($sql) === TRUE) {
        echo "Record deleted successfully<br>";

        // Debug: Output the SQL query executed
        echo "SQL Query: " . $sql . "<br>";

        header("location:/dbshop1/index.php"); // Change to the actual path
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    // Close the connection
    $connection->close();
} else {
    echo "Invalid adopter ID";
}
?>
