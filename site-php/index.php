<?php
require 'vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Обработка POST запроса на добавление обратной связи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = htmlspecialchars($_POST['text']);
    $name = htmlspecialchars($_POST['name']);
    $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
    $email = htmlspecialchars($_POST['email']);

    if (preg_match('/^(?:\+7|8)\d{10}$/', $phoneNumber)) {
        if (strpos($email, '@') !== false) {
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
            echo "Invalid email address.";
        }
    } else {
        echo "Invalid phone number format.";
    }
} else {
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $database = $_ENV['DB_DATABASE'];

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT name, phone_number, email, text FROM feedback";
    $result = $conn->query($sql);

    $feedbackData = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $feedbackData[] = $row;
        }
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($feedbackData);
}
?>
