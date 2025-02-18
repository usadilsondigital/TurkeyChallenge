<?php
require 'Database.php';
require 'TurkeyRepository.php';
require 'TurkeyController.php';

$db = Database::getInstance();
$repository = new TurkeyRepository($db);
$controller = new TurkeyController($repository);

// Load available turkey files
$files = glob("turkey_*.txt");
$turkey = null;

// Handle file selection and loading
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['load_file'])) {
    $filename = $_POST['selected_file'];
    if (file_exists($filename)) {
        $data = file_get_contents($filename);
        $turkey = json_decode($data, true);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Load Turkey from File</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        function saveTurkey() {
            let id = document.getElementById("turkey_id").value;
            let name = document.getElementById("turkey_name").value;
            let status = document.getElementById("turkey_status").value;
            let size = document.getElementById("turkey_size").value;
            let color = document.getElementById("turkey_color").value;
            let gender = document.getElementById("turkey_gender").value;

            if (!confirm("Are you sure you want to save this turkey to the database?")) {
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "save_turkey_ajax.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    let messageDiv = document.getElementById("message");
                    messageDiv.style.display = "block";
                    messageDiv.className = response.success ? "alert alert-success mt-3" : "alert alert-danger mt-3";
                    messageDiv.innerHTML = response.message;
                }
            };

            let data = `id=${id}&name=${name}&status=${status}&size=${size}&color=${color}&gender=${gender}`;
            xhr.send(data);
        }
    </script>
    <script>
        function validateForm() {
            let select = document.getElementById("selected_file");
            let errorMessage = document.getElementById("error-message");

            if (select.value === "") {
                errorMessage.style.display = "block";
                return false;
            }

            errorMessage.style.display = "none";
            return true;
        }
</script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary"><i class="fas fa-file-upload"></i> Load a Turkey from File</h2>

        <!-- Success/Error Message -->
        <div id="message" style="display: none;"></div>

        <!-- File selection form -->
        <div class="card p-4 shadow-sm">
        <form method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label class="form-label">Select a turkey file:</label>
                    <div class="input-group">
                        <select class="form-select" name="selected_file" id="selected_file">
                            <option value="">-- Select a file --</option>
                            <?php foreach ($files as $file): ?>
                                <option value="<?= $file ?>"><?= $file ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="load_file" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Load Turkey
                        </button>
                    </div>
                    <small id="error-message" class="text-danger" style="display: none;">Please select a turkey file.</small>
                </div>
            </form>
        </div>

        <br>

        <!-- Display the loaded turkey -->
        <?php if ($turkey): ?>
            <div class="card p-4 shadow-sm mt-4">
                <h4 class="text-success"><i class="fas fa-info-circle"></i> Turkey Details</h4>
                <p><strong>ID:</strong> <input type="text" id="turkey_id" class="form-control" value="<?= $turkey['id'] ?>" ></p>
                <p><strong>Name:</strong> <input type="text" id="turkey_name" class="form-control" value="<?= htmlspecialchars($turkey['name']) ?>"></p>
                <p><strong>Status:</strong> 
                    <select id="turkey_status" class="form-select">
                        <option value="online" <?= $turkey['status'] == 'online' ? 'selected' : '' ?>>Online</option>
                        <option value="offline" <?= $turkey['status'] == 'offline' ? 'selected' : '' ?>>Offline</option>
                        <option value="limbo" <?= $turkey['status'] == 'limbo' ? 'selected' : '' ?>>Limbo</option>
                    </select>
                </p>
                <p><strong>Size:</strong> <input type="number" id="turkey_size" class="form-control" value="<?= $turkey['size'] ?>"></p>
                <p><strong>Color:</strong> <input type="text" id="turkey_color" class="form-control" value="<?= htmlspecialchars($turkey['color']) ?>"></p>
                <p><strong>Gender:</strong> 
                    <select id="turkey_gender" class="form-select">
                        <option value="male" <?= $turkey['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $turkey['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </p>
                <button type="button" class="btn btn-success" onclick="saveTurkey()"><i class="fas fa-save"></i> Save to Database</button>
            </div>
        <?php endif; ?>

        <br>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Turkeys List</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
