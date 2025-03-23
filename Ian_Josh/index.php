<?php
include "connection.php";

$sql = "SELECT * FROM employee";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Record</title>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background: linear-gradient(135deg,rgb(238, 180, 212),rgb(169, 90, 164));
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
        width: 90%;
        max-width: 1200px;
    }
    h2 {
        margin-bottom: 10px;
        color: #333;
        text-align: center;
        font-size: 28px;
    }
    .add-employee-btn {
        display: inline-block;
        background-color:rgb(3, 133, 214);
        color: #fff;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }
    .add-employee-btn:hover {
        background-color:rgb(131, 132, 134);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: rgb(168, 127, 2);
        color: white;
        font-weight: bold;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    a {
        color:rgb(14, 106, 204);  
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    .action-btns {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .edit-btn, .delete {
        padding: 8px 16px;
        font-size: 14px;
        font-weight: bold;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .edit-btn {
        background-color: #28a745;
    }
    .edit-btn:hover {
        background-color: rgb(142, 146, 143);
    }
    .delete {
        background-color: #dc3545;
    }
    .delete:hover {
        background-color: rgb(124, 121, 121);
    }
    @media (max-width: 768px) {
        table {
            font-size: 14px;
        }
        th, td {
            padding: 8px;
        }
        .add-employee-btn {
            font-size: 14px;
            padding: 10px 20px;
        }
    }
    </style>
</head>
<body>
<div class="container">
    <h2>Employee Record</h2>
    <a href="add_employee.php" class="add-employee-btn">Add Employee</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['first_name']; ?></td>
                <td><?= $row['last_name']; ?></td>
                <td><?= $row['department']; ?></td>
                <td><?= $row['salary']; ?></td>
                <td class="action-btns">
                    <a href="edit_employee.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                    <form method="POST" action="delete_employee.php" onsubmit="return confirm('Are you sure you want to delete this employee?');" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <button class="delete" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>