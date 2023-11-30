<?php
// process.php
phpinfo();
if (isset($_GET['text']) && isset($_GET['site'])) {
    $inputText = $_GET['text'];
    $site = $_GET['site'];

    if (!empty($inputText)) {
        echo "Received from $site: " . htmlspecialchars($inputText);
    } else {
        echo "Text is empty.";
    }
} else {
    echo "Missing text or site parameter.";
}
?>
