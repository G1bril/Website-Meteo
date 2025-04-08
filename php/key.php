<?php
// API key
$apiKey = '2962802eb10e823968a8430629f72725';

// Encrypt API key using base64 encoding
$encryptedApiKey = base64_encode($apiKey);

// Return encrypted API key as JSON
header('Content-Type: application/json');
echo json_encode(array("apiKey" => $encryptedApiKey));
?>
