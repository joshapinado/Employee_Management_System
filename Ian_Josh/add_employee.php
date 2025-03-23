<?php
include 'connection.php'; 

$first_name = $last_name = $department = $salary = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $department = trim($_POST['department']);
    $salary = trim($_POST['salary']);

    $stmt = $conn->prepare("SELECT id FROM employee WHERE first_name = ? AND last_name = ?");
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Employee already exists!";
    } else {
        $id_result = $conn->query("SELECT (t1.id + 1) AS next_id FROM employee t1 WHERE NOT EXISTS (SELECT * FROM employee t2 WHERE t2.id = t1.id + 1) ORDER BY t1.id ASC LIMIT 1");
        $row = $id_result->fetch_assoc();
        $new_id = $row['next_id'] ?? 1;

        $insert_stmt = $conn->prepare("INSERT INTO employee (id, first_name, last_name, department, salary) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("issss", $new_id, $first_name, $last_name, $department, $salary);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Employee Added Successfully'); window.location.href = 'index.php';</script>";
            exit();
        }
         else {
            $error_message = "Error: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            font-size: 24px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back {
            background-color: #6c757d;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .back:hover {
            background-color: #5a6268;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body onload="showError('<?php echo $error_message; ?>')">
    <div class="container">
        <h2>Add Employee</h2>
        <?php if (!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form action="" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" placeholder="John" value="<?php echo htmlspecialchars($first_name); ?>" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" placeholder="Doe" value="<?php echo htmlspecialchars($last_name); ?>" required>
            <label for="department">Department:</label>
            <input type="text" id="department" name="department" placeholder="Department" value="<?php echo htmlspecialchars($department); ?>" required>
            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" placeholder="50000" min="0" step="1000" value="<?php echo htmlspecialchars($salary); ?>" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <form action="index.php">
            <button class="back">Back</button>
        </form>
    </div>
    <script>
        function showError(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</body>
</html>