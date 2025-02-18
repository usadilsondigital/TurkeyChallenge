<?php
require 'Database.php';
require 'TurkeyRepository.php';
require 'TurkeyController.php';

$db = Database::getInstance();
$repository = new TurkeyRepository($db);
$controller = new TurkeyController($repository);

$report = $controller->getAllTurkeysOrder();

// Count statuses
$onlineCount = 0;
$offlineCount = 0;
$limboCount = 0;

foreach ($report as $row) {
    if ($row['status'] == 'online') {
        $onlineCount++;
    } elseif ($row['status'] == 'offline') {
        $offlineCount++;
    } else {
        $limboCount++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Turkey Status Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary"><i class="fas fa-chart-bar"></i> Turkey Status Report</h2>

        <!-- Status Tiles -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Onlines</h5>
                        <p class="card-text display-6"> <?= $onlineCount ?> </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Offlines</h5>
                        <p class="card-text display-6"> <?= $offlineCount ?> </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-dark bg-warning shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Limbos</h5>
                        <p class="card-text display-6"> <?= $limboCount ?> </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table displaying turkey statuses -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td>
                                <?php if ($row['status'] == 'online'): ?>
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Online</span>
                                <?php elseif ($row['status'] == 'offline'): ?>
                                    <span class="badge bg-secondary"><i class="fas fa-power-off"></i> Offline</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Limbo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Turkeys List</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
