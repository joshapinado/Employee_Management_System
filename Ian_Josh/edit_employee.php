<?php
include "connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employee WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

$error_message = "";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];

    $check_sql = "SELECT * FROM employee WHERE first_name='$first_name' AND last_name='$last_name' AND id != $id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Error: An employee with the same name already exists.";
    } else {
        $sql = "UPDATE employee SET first_name='$first_name', last_name='$last_name', department='$department', salary='$salary' WHERE id=$id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Data Updated Successfully'); window.location.href = 'index.php';</script>";
            exit();
        } else {
            $error_message = "Error: Data Update Failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Record</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            font-family: sans-serif;
            margin: 0;
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
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
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
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body onload="showError('<?php echo $error_message; ?>')">
    <div class="container">
        <h2>Edit Employee Record</h2>
        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
            <label for="department">Department:</label>
            <input type="text" name="department" value="<?php echo $row['department']; ?>" required>
            <label for="salary">Salary:</label>
            <input type="number" name="salary" value="<?php echo $row['salary']; ?>" required>
            <input type="submit" name="update" value="Update">
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