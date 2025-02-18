<?php
require 'Database.php';
require 'TurkeyRepository.php';
require 'TurkeyController.php';

$db = Database::getInstance();
$repository = new TurkeyRepository($db);
$controller = new TurkeyController($repository);

if (isset($_GET['id'])) {
    $turkey = $controller->listTurkeys()[array_search($_GET['id'], array_column($controller->listTurkeys(), 'id'))] ?? null;

    if ($turkey) {
        $filename = "turkey_{$turkey['id']}" . date("Ymd_His") . ".txt";
        $data = json_encode($turkey, JSON_PRETTY_PRINT);

        if (file_put_contents($filename, $data)) {
            echo "<script>alert('Turkey saved successfully to file: $filename'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error saving turkey to file!'); window.location.href = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('Turkey not found!'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('No turkey ID provided!'); window.location.href = 'index.php';</script>";
}
?>