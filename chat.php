<?php
header('Content-Type: application/json');

// Load .env file manually
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

// Call function to load .env
loadEnv(__DIR__ . '/.env');

// Load API key
$apiKey = $_ENV['GROQ_API_KEY'] ?? null;

if (!$apiKey) {
    echo json_encode(["reply" => "⚠️ API key missing. Please check your .env file."]);
    exit;
}

// Get input
$input = json_decode(file_get_contents("php://input"), true);
$userMessage = $input['message'] ?? "";

// Call Groq API (ChatGPT-like)
$ch = curl_init("https://api.groq.com/openai/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);

$data = [
    "model" => "llama-3.1-8b-instant",
    "messages" => [
        ["role" => "system", "content" => "You are ChatGPT, a helpful and professional AI assistant. Answer clearly and naturally."],
        ["role" => "user", "content" => $userMessage]
    ]
];

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
$reply = $result['choices'][0]['message']['content'] ?? "⚠️ Sorry, I couldn't generate a response.";

echo json_encode(["reply" => $reply]);
