<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 2; // Test fallback auto-login
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['type']) || !isset($input['value'])) {
    echo json_encode(["status" => "error", "message" => "Invalid inputs"]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "unipulse");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database down"]);
    exit();
}

$type = $input['type'];
$val = $input['value'];

if ($type === 'mood') {
    $stmt = $conn->prepare("INSERT INTO user_moods (user_id, mood, log_date) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE mood = ?");
    $stmt->bind_param("isss", $user_id, $val, $today, $val);
    $stmt->execute();
} 
set_time_limit(5);
if ($type === 'water') {
    $change = (float)$val; // Sends +0.25 or -0.25 from front-end
    
    // Check current amount first
    $chk = $conn->prepare("SELECT amount_liters FROM user_water WHERE user_id = ? AND log_date = ?");
    $chk->bind_param("is", $user_id, $today);
    $chk->execute();
    $res = $chk->get_result()->fetch_assoc();
    $current = $res ? (float)$res['amount_liters'] : 0.0;
    $new_amount = max(0, $current + $change);
    
    $stmt = $conn->prepare("INSERT INTO user_water (user_id, amount_liters, log_date) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE amount_liters = ?");
    $stmt->bind_param("idsd", $user_id, $new_amount, $today, $new_amount);
    $stmt->execute();
}
if ($type === 'meals') {
    $change = (int)$val; // Sends +1 or -1 from front-end
    
    $chk = $conn->prepare("SELECT meals_eaten, total_meals FROM user_meals WHERE user_id = ? AND log_date = ?");
    $chk->bind_param("is", $user_id, $today);
    $chk->execute();
    $res = $chk->get_result()->fetch_assoc();
    $current = $res ? (int)$res['meals_eaten'] : 0;
    $total = $res ? (int)$res['total_meals'] : 3;
    $new_meals = max(0, min($current + $change, $total));
    
    $stmt = $conn->prepare("INSERT INTO user_meals (user_id, meals_eaten, total_meals, log_date) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE meals_eaten = ?");
    $stmt->bind_param("iiisii", $user_id, $new_meals, $total, $today, $new_meals);
    $stmt->execute();
}

echo json_encode(["status" => "success"]);
$conn->close();
?>