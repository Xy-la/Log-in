<?php
include 'db.php';

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM residents WHERE id = $id");
    $resident = $result->fetch_assoc();

    if (!$resident) {
        echo "Resident not found!";
        exit;
    }
} else {
    echo "Invalid Request!";
    exit;
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $resident_name = $conn->real_escape_string($_POST['resident_name']);
    $age = intval($_POST['age']);
    $address = $conn->real_escape_string($_POST['address']);

    $conn->query("UPDATE residents SET resident_name='$resident_name', age=$age, address='$address' WHERE id = $id");

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resident</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            max-width: 500px;
        }

        h1 {
            color: #2c3e50;
            font-size: 30px;
            margin: 0;
            text-align: center;
        }

        label {
            font-size: 14px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>Edit Resident</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $resident['id'] ?>">

            <label for="resident_name">Resident Name:</label>
            <input type="text" id="resident_name" name="resident_name" value="<?= $resident['resident_name'] ?>" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?= $resident['age'] ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?= $resident['address'] ?>" required>

            <button type="submit" name="update">Update Resident</button>
        </form>
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>

</html>