<?php
session_start();
include 'connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_bill'])) {
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $amount = $_POST['amount'];
        $payment_date = $_POST['payment_date'];
        $payment_status = $_POST['payment_status'];

        $sql = "INSERT INTO billing (patient_id, doctor_id, amount, payment_date, payment_status) 
                VALUES ('$patient_id', '$doctor_id', '$amount', 
                        " . ($payment_date ? "'$payment_date'" : "NULL") . ", 
                        '$payment_status')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New billing record added successfully.');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Fetch billing records
$result = $conn->query("SELECT * FROM billing");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            color: #0056b3;
        }
        h1 {
            margin-top: 20px;
            font-size: 2.5em;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 1.8em;
        }
        form {
            width: 50%;
            margin: 0 auto 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            margin-top: 10px;
        }
        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        form button {
            background-color: #0056b3;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #003d80;
        }
        table {
            width: 90%;
            margin: 0 auto 50px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        table thead {
            background-color: #0056b3;
            color: #fff;
        }
        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        @media (max-width: 768px) {
            form {
                width: 90%;
            }
            table {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <h1>Billing Management</h1>

    <h2>Add New Billing</h2>
    <form method="POST" action="">
        <label for="patient_id">Patient ID:</label>
        <input type="number" name="patient_id" required>

        <label for="doctor_id">Doctor ID:</label>
        <input type="number" name="doctor_id" required>

        <label for="amount">Amount:</label>
        <input type="number" step="0.01" name="amount" required>

        <label for="payment_date">Payment Date:</label>
        <input type="date" name="payment_date">

        <label for="payment_status">Payment Status:</label>
        <select name="payment_status">
            <option value="Unpaid">Unpaid</option>
            <option value="Done">Done</option>
        </select>

        <button type="submit" name="add_bill">Add Bill</button>
    </form>

    <h2>Billing Records</h2>
    <table>
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Patient ID</th>
                <th>Doctor ID</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['bill_id']; ?></td>
                        <td><?php echo $row['patient_id']; ?></td>
                        <td><?php echo $row['doctor_id']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['payment_date'] ?: '-'; ?></td>
                        <td><?php echo $row['payment_status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No billing records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
