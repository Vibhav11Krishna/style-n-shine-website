<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Load Composer Autoload
require __DIR__ . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get API Key from .env
$groqApiKey = $_ENV['GROQ_API_KEY'];

$data = json_decode(file_get_contents("php://input"), true);
$userMsg = strtolower(trim($data["message"] ?? ""));

// Salon Details
$numbers = "+91 9199825858, +91 9263930196, +91 6124487221";

$address = "Address:
G-01, Rana Residency,
E Boring Canal Rd, behind Vishnu Place,
near Oro Dental, Rai jee Lane,
Kidwaipuri, Patna, Bihar 800001

Call us at: $numbers";

$services = "Our Services:
Haircut, Blowouts, Hairstyling, Hair Coloring, Keratin/Smoothening, Hair Spa, Hair Extensions, Acrylic Nails, Manicure, Pedicure, Facials, Skin Care, Body Polishing, Tanning, Makeup, Bridal Services, Eyelash Extensions, Eyebrow Threading, Waxing, Massage, Spa Services, Aroma Therapy Massage, Saree Draping, Blouse Stitching, Lehenga Alteration, Fall & Pico";

$hours = "Working Hours:
10:00 AM to 9:00 PM (All Days Open)";

$reply = "";

/* Predefined Responses */
if(strpos($userMsg, "address") !== false){
    $reply = $address;
}
elseif(strpos($userMsg, "service") !== false){
    $reply = $services;
}
elseif(strpos($userMsg, "hour") !== false || strpos($userMsg, "time") !== false){
    $reply = $hours;
}

/* If no predefined match → Use Groq AI */
if(empty($reply) && !empty($userMsg)){

    $postData = [
        "model" => "llama-3.3-70b-versatile",
        "messages" => [
            [
                "role" => "system",
                "content" => "You are a helpful and polite assistant for Style N Shine Salon in Patna. Give short, professional answers."
            ],
            [
                "role" => "user",
                "content" => $userMsg
            ]
        ]
    ];

    $ch = curl_init("https://api.groq.com/openai/v1/chat/completions");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $groqApiKey
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);

    if($response === false){
        $reply = "cURL Error: " . curl_error($ch);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($httpCode != 200){
            $reply = "HTTP Error $httpCode";
        } else {
            $result = json_decode($response, true);
            $reply = $result["choices"][0]["message"]["content"] ?? "Invalid API response.";
        }
    }

    curl_close($ch);
}

echo json_encode(["reply" => $reply]);
?>