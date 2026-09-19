<?php
header("Content-Type: application/json");


$apiKey =  "YOUR_API_KEY_HERE"; 


$input = json_decode(file_get_contents("php://input"), true);
$prompt = isset($input['prompt']) ? $input['prompt'] : '';

if (empty($prompt)) {
    echo json_encode(["error" => "Prompt is empty"]);
    exit;
}


$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;


$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt]
            ]
        ]
    ]
];


$options = [
    "http" => [
        "method" => "POST",
        "header" => "Content-Type: application/json\r\n",
        "content" => json_encode($data),
        "ignore_errors" => true
    ],
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);


if ($response !== false) {
    echo $response;
} else {
    echo json_encode(["error" => "Failed to connect to Google API Server."]);
}
?>