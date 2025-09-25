<?php
// process.php
header('Content-Type: application/json');

// Simple .env loader (no Composer needed)
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // skip comments
        }
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        $_ENV[$name] = $value;
        putenv("$name=$value");
    }
}

// Load .env file
loadEnv(__DIR__ . '/.env');

// Get API key from .env
$apiKey = $_ENV['GROQ_API_KEY'] ?? null;

if (!$apiKey) {
    echo json_encode(['error' => '⚠️ API key missing. Please check your .env file.']);
    exit;
}

// Get the user message from POST request
$userMessage = $_POST['message'] ?? '';

if (!$userMessage) {
    echo json_encode(['error' => 'No message provided']);
    exit;
}

// API endpoint
$url = "https://api.groq.com/openai/v1/chat/completions";

// Data to send
$data = [
    "model" => "llama-3.1-8b-instant",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are a professional AI assistant. Provide clear, accurate, and helpful answers. Be concise, respectful, and smart, like ChatGPT."
        ],
        [
            "role" => "user",
            "content" => $userMessage
        ]
    ]
];

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    exit;
}
curl_close($ch);

// Decode API response
$responseData = json_decode($response, true);

// Extract assistant reply safely
$assistantReply = $responseData['choices'][0]['message']['content'] ?? "No reply from AI.";

// Return only the reply as JSON
echo json_encode([
    "reply" => $assistantReply
]);
