<?php
session_start();
header('Content-Type: application/json');

// FOR TEST PURPOSES: If no active session, auto-login as User 2 so it doesn't kick you out
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 2;
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$conn = new mysqli("localhost", "root", "", "unipulse");
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// 1. Fetch User Profile
$user_stmt = $conn->prepare("SELECT full_name, major, year FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$userInfo = $user_stmt->get_result()->fetch_assoc();

// 2. Fetch Mood
$mood_stmt = $conn->prepare("SELECT mood FROM user_moods WHERE user_id = ? AND log_date = ?");
$mood_stmt->bind_param("is", $user_id, $today);
$mood_stmt->execute();
$mood_res = $mood_stmt->get_result()->fetch_assoc();
$currentMood = $mood_res ? $mood_res['mood'] : 'Okay';

// 3. Fetch Water
$water_stmt = $conn->prepare("SELECT amount_liters FROM user_water WHERE user_id = ? AND log_date = ?");
$water_stmt->bind_param("is", $user_id, $today);
$water_stmt->execute();
$water_res = $water_stmt->get_result()->fetch_assoc();
$waterAmount = $water_res ? (float)$water_res['amount_liters'] : 0.0;

// 4. Fetch Meals
$meal_stmt = $conn->prepare("SELECT meals_eaten, total_meals FROM user_meals WHERE user_id = ? AND log_date = ?");
$meal_stmt->bind_param("is", $user_id, $today);
$meal_stmt->execute();
$meal_res = $meal_stmt->get_result()->fetch_assoc();
$mealsEaten = $meal_res ? (int)$meal_res['meals_eaten'] : 0;
$totalMeals = $meal_res ? (int)$meal_res['total_meals'] : 3;

// 5. Fetch Tasks
$tasks = [];
$tasks_stmt = $conn->prepare("SELECT id, name, status, tag FROM tasks WHERE user_id = ?");
if ($tasks_stmt) {
    $tasks_stmt->bind_param("i", $user_id);
    $tasks_stmt->execute();
    $tasks_result = $tasks_stmt->get_result();
    while ($row = $tasks_result->fetch_assoc()) {
        $tasks[] = $row;
    }
    $tasks_stmt->close();
}

// 6. Hardcoded Safe Schedule Mock Layout
$schedule = [
    "8am" => ["type" => "free", "name" => "Free time"],
    "10am" => ["type" => "class", "name" => "Web Dev Lecture", "sub" => "Room 402"],
    "1pm" => ["type" => "free", "name" => "Lunch Break"]
];

// Calculate Dynamic Live Wellness Score
$pendingTasks = array_filter($tasks, function($t) { return $t['status'] === 'pending'; });
$taskScore = count($tasks) > 0 ? ((count($tasks) - count($pendingTasks)) / count($tasks)) * 50 : 25;
$waterScore = min(($waterAmount / 3.0) * 25, 25); 
$mealScore = min(($mealsEaten / $totalMeals) * 25, 25);
$wellnessScore = round($taskScore + $waterScore + $mealScore);

echo json_encode([
    "userInfo" => $userInfo,
    "currentMood" => $currentMood,
    "waterAmount" => $waterAmount,
    "mealsEaten" => $mealsEaten,
    "totalMeals" => $totalMeals,
    "wellnessScore" => $wellnessScore,
    "tasks" => $tasks,
    "schedule" => $schedule 
]);

$conn->close();
?>