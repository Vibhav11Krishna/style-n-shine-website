<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // allow AJAX requests

$data = json_decode(file_get_contents("php://input"), true);
$userMsg = strtolower(trim($data["message"] ?? ""));

// Salon info
$numbers = "+91 9199825858, +91 9263930196, +91 6124487221";
$address = "G-01, Rana Residency,\nE Boring Canal Rd, behind Vishnu Place,\nnear Oro Dental, Rai jee Lane,\nKidwaipuri, Patna, Bihar 800001";
$bookingInstructions = "Go to the booking section on the website, add your initials, and select a slot.\nWorking hours: 10:00 AM to 9:00 PM";

// Predefined responses
$responses = [
    "hi"=> "Hello! Welcome to Style N Shine 💇‍♀️. How can I help you today?",
    "hello"=> "Hello! Welcome to Style N Shine 💇‍♀️. How can I assist you?",
    "who are you"=> "I am the chat assistant of Style N Shine Parlour 💇‍♀️",
    "address"=> "📍 Address:\n$address\n\n📞 Call us at: $numbers",
    "contact"=> "📞 Call us at: $numbers\n📍 Address:\n$address",
    "call"=> "📞 Call us at: $numbers",
    "booking"=> "📝 Booking Instructions:\n$bookingInstructions",
    "services"=> "💇‍♀️ Our Services:\nHaircut, Blowouts, Hairstyling, Hair Coloring, Keratin/Smoothening, Hair Spa, Hair Extensions, Acrylic Nails, Manicure, Pedicure, Facials, Skin Care, Body Polishing, Tanning, Makeup, Bridal Services, Eyelash Extensions, Eyebrow Threading, Waxing, Massage, Spa Services, Aroma Therapy Massage, Saree Draping, Blouse Stitching, Lehenga Alteration, Fall & Pico",
    "timing"=> "⏰ Working Hours: 10:00 AM to 9:00 PM",
    "hours"=> "⏰ Working Hours: 10:00 AM to 9:00 PM",
    "thank you"=> "You are welcome! 😊",
    "thanks"=> "You are welcome! 😊",
    "bye"=> "Goodbye! Have a great day! 💇‍♀️"
];

$reply = "Sorry, I didn't understand. You can ask about services, booking, address, phone, or working hours.";

// Match user message
foreach($responses as $key=>$value){
    if(strpos($userMsg,$key)!==false){
        $reply = $value;
        break;
    }
}

echo json_encode(["reply"=>$reply]);
?>
