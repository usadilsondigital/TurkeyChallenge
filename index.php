<?php
require 'Database.php';
require 'TurkeyRepository.php';
require 'TurkeyController.php';

$db = Database::getInstance();
$repository = new TurkeyRepository($db);
$controller = new TurkeyController($repository); 
$turkeys = $controller->listTurkeys();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($controller->removeTurkey($id)) {
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error deleting turkey.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Turkeys List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        function confirmSaveToFile(id) {
            if (confirm("Are you sure you want to save this turkey to a file?")) {
                window.location.href = "save_to_file.php?id=" + id;
            }
        }
    </script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-primary"><i class="fas fa-drumstick-bite"></i> Turkeys List</h2>

        <!-- Navigation Buttons -->
        <div class="mb-3">
            <a href="add.php" class="btn btn-success"><i class="fas fa-plus"></i> Add New Turkey</a>
            <a href="load_turkey_from_file.php" class="btn btn-primary"><i class="fas fa-upload"></i> Load Turkey from File</a>
            <a href="report.php" class="btn btn-info"><i class="fas fa-file-alt"></i> Turkey Report by Status</a>
        </div>

        <!-- Table to display turkeys -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Gender</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turkeys as $turkey): ?>
                        <tr>
                            <td><?= $turkey['id'] ?></td>
                            <td><?= $turkey['name'] ?></td>
                            <td>
                                <?php if ($turkey['status'] == 'online'): ?>
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Online</span>
                                <?php elseif ($turkey['status'] == 'offline'): ?>
                                    <span class="badge bg-secondary"><i class="fas fa-power-off"></i> Offline</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Limbo</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $turkey['size'] ?></td>
                            <td><?= $turkey['color'] ?></td>
                            <td>
                                <?= $turkey['gender'] == 'male' ? '<i class="fas fa-mars text-primary"></i> Male' : '<i class="fas fa-venus text-danger"></i> Female' ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $turkey['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                               
                                <a href="index.php?delete=<?= $turkey['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>

                                <button class="btn btn-info btn-sm" onclick="confirmSaveToFile(<?= $turkey['id'] ?>)">
                                    <i class="fas fa-save"></i> Save to File
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <br>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Home</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>