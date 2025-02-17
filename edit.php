<?php
require 'db.php';
require 'Turkey.php';

$turkeyModel = new Turkey($pdo);
$turkey = $turkeyModel->getTurkey($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turkeyModel->updateTurkey($_GET['id'], $_POST['name'], $_POST['status'], $_POST['size'], $_POST['color'], $_POST['gender']);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Turkey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary"><i class="fas fa-edit"></i> Edit Turkey</h2>

        <div class="card shadow-sm p-4">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-signature"></i> Name</label>
                    <input type="text" name="name" class="form-control" value="<?= $turkey['name'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-signal"></i> Status</label>
                    <select name="status" class="form-select">
                        <option value="online" <?= $turkey['status'] == 'online' ? 'selected' : '' ?>>🟢 Online</option>
                        <option value="offline" <?= $turkey['status'] == 'offline' ? 'selected' : '' ?>>⚫ Offline</option>
                        <option value="limbo" <?= $turkey['status'] == 'limbo' ? 'selected' : '' ?>>🟡 Limbo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-ruler-vertical"></i> Size</label>
                    <input type="number" name="size" class="form-control" value="<?= $turkey['size'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-palette"></i> Color</label>
                    <input type="text" name="color" class="form-control" value="<?= $turkey['color'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-venus-mars"></i> Gender</label>
                    <select name="gender" class="form-select">
                        <option value="male" <?= $turkey['gender'] == 'male' ? 'selected' : '' ?>>♂️ Male</option>
                        <option value="female" <?= $turkey['gender'] == 'female' ? 'selected' : '' ?>>♀️ Female</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Turkey</button>
            </form>
        </div>

        <br>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Turkeys List</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
