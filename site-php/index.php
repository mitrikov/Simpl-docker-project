<?php

require 'vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_GET['text']) && isset($_GET['site'])) {
    $inputText = $_GET['text'];
    $site = $_GET['site'];

    if (!empty($inputText)) {
        $servername = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $database = $_ENV['DB_DATABASE'];

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO first_table (name) VALUES ('$inputText')";
        if ($conn->query($sql) === TRUE) {
            echo "Received from $site: " . htmlspecialchars($inputText) . " and inserted into MySQL successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Text is empty.";
    }
} else {
    echo "Missing text or site parameter.";
}
?>
