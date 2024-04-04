<?php

// Check if the language parameter is set to 'en'
if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
    $fileUrl = 'https://wordpress.org/latest.zip'; // English version URL
} else {
    $fileUrl = 'https://fa.wordpress.org/latest-fa_IR.zip'; // Farsi version URL
}

// The path & filename to save to.
$saveTo = 'wordpress.zip';

// Open file handler.
$fp = fopen($saveTo, 'w+');

// If $fp is FALSE, something went wrong.
if ($fp === false) {
    throw new Exception('Could not open: ' . $saveTo);
}

// Create a cURL handle.
$ch = curl_init($fileUrl);

// Pass our file handle to cURL.
curl_setopt($ch, CURLOPT_FILE, $fp);

// Timeout if the file doesn't download after 60 seconds.
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

// Execute the request.
curl_exec($ch);

// If there was an error, throw an Exception
if (curl_errno($ch)) {
    throw new Exception(curl_error($ch));
}

// Get the HTTP status code.
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close the cURL handler.
curl_close($ch);

// Close the file handler.
fclose($fp);

if ($statusCode == 200) {

    echo "Finish";

} else {
    echo "❌ Status Code: " . $statusCode;
}
?>