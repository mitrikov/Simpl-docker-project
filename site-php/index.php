<?php

if (isset($_GET['text']) && isset($_GET['site'])) {
    $inputText = $_GET['text'];
    $site = $_GET['site'];

    if (!empty($inputText)) {
        $servername = "mysql";
        $username = "admin";
        $password = "admin";
        $database = "sample-data";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO your_table_name (column_name) VALUES ('$inputText')";
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
