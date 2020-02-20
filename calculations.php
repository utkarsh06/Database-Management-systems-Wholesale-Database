<?php 
    include "connect.php";
    if (isset($_POST['check_button_paid_pending'])){
        $status = $_POST['status'];
        $status_str = $status ? "Paid": "Pending";
        echo "<h2>Amounts that are $status_str</h2>";
        echo "<table><tr><th>Customer Name</th><th>Payment</th><th>Date</th></tr>";
        $query = "SELECT customer.first_name, customer.last_name, revenue.payment, revenue.revenue_date FROM customer, revenue WHERE customer.customer_id LIKE revenue.customer_id AND revenue.status LIKE '$status'";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
            $name = $row['first_name'] . " " . $row['last_name'];
            $payment = $row['payment'];
            $date = $row['revenue_date'];
            echo "<tr><td>$name</td><td>$payment</td><td>$date</td></tr>";
        }
        echo "</table>";
    }
    if (isset($_POST['calculate_profit'])){
        $begin_date = $_POST['begin_date'];
        $end_date = $_POST['end_date'];
        $query = "SELECT SUM(payment) AS sum_payment, status FROM revenue WHERE revenue_date BETWEEN '$begin_date' AND '$end_date' GROUP BY status";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result)==0){
            echo "No Results Found";
        }
        else {
            $total_revenue = 0;
            echo "<h1>Profit</h1>";
            echo "<h2>$begin_date / $end_date</h2>";
            echo "<table>";
            while ($row = mysqli_fetch_assoc($result)){
                $status = $row['status'] ? "Paid" : "Pending";
                $sum_payment = round($row['sum_payment'], 2);
                $total_revenue += $sum_payment; 
                echo "<tr><td>$status</td><td>$sum_payment</td></tr>";
            }
            echo "<tr><td>Total</td><td>$total_revenue</td></tr></table>";
        }
    }
    if (isset($_POST['calculate_stock_to_buy'])){
        $query = "SELECT name, quantity, min_quantity, unit_cost FROM stock WHERE quantity < min_quantity";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 0){
            echo "No Stock To Buy";
        }
        else{
            echo "<table><tr><th>Name</th><th>Quantity to Buy</th><th>Total</th></tr>";
            while ($row = mysqli_fetch_assoc($result)){
                $name = $row['name'];
                $quantity_to_buy = $row['min_quantity'] - $row['quantity'];
                $total_cost = $row['unit_cost'] * $quantity_to_buy;
                echo "<tr><td>$name</td><td>$quantity_to_buy</td><td>$total_cost</td></tr>";
            }
            echo "</table>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
