<?php
require 'Database.php';
require 'TurkeyRepository.php';
require 'TurkeyController.php';

header("Content-Type: application/json");

$db = Database::getInstance();
$repository = new TurkeyRepository($db);
$controller = new TurkeyController($repository);

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $gender = $_POST['gender'];

    $existing = $controller->listTurkeys()[array_search($id, array_column($controller->listTurkeys(), 'id'))] ?? null;

    if ($existing) {
        $response["message"] = "❌ Error: This turkey already exists in the database!";
    } else {
        $success = $controller->createTurkey($name, $status, $size, $color, $gender);
        if ($success) {
            $response["success"] = true;
            $response["message"] = "✅ Turkey saved successfully to the database!";
        } else {
            $response["message"] = "❌ Error: Failed to save turkey. Please try again.";
        }
    }
}

echo json_encode($response);
?>
