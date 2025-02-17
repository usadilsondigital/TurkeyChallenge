<?php
require 'db.php';
require 'Turkey.php';

$turkeyModel = new Turkey($pdo);

if (isset($_GET['id'])) {
    $turkey = $turkeyModel->getTurkey($_GET['id']);

    if ($turkey) {
        $filename = "turkey_{$turkey['id']}_" . date("Ymd_His") . ".txt";
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
