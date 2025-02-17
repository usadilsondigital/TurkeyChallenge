<?php
require 'db.php';
require 'Turkey.php';

header("Content-Type: application/json");

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $gender = $_POST['gender'];

    $turkeyModel = new Turkey($pdo);
    $existing = $turkeyModel->loadTurkey($id);

    if ($existing) {
        $response["message"] = "❌ Error: This turkey already exists in the database!";
    } else {
        $success = $turkeyModel->saveTurkey($name, $status, $size, $color, $gender);
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
