<?php
require 'vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = $_POST['text'];
    $name = $_POST['name'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];

    if (!empty($inputText)) {
        $servername = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $database = $_ENV['DB_DATABASE'];

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = $conn->prepare("INSERT INTO feedback (name, phone_number, email, text) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $name, $phoneNumber, $email, $inputText);

        if ($sql->execute()) {
            echo "Data inserted into MySQL successfully.";
        } else {
            echo "Error inserting record: " . $sql->error;
        }

        $sql->close();
        $conn->close();
    } else {
        echo "Text is empty.";
    }
} else {
    echo "Invalid request method.";
}
?>
