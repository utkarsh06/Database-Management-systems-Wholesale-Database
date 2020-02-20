<?php
    include "connect.php";
    include "functions.php";

    if (isset($_POST['buyer_insert'])){
        $buyer_name = $_POST['buyer_name'];
        $buyer_address = $_POST['buyer_address'];
        if (strpos($buyer_name, "'")){
            $array = [];
            $char = str_split($buyer_name);
            $count = 0;
            $index = 0;
            foreach($char as $character){
                if ($character == "'"){
                    $array[$index] = $count;
                    $index += 1;
                }
                $count += 1;
            }
            $array = array_reverse($array);
            $index = 0;
            foreach($array as $location){
                $buyer_name = substr_replace($buyer_name, "'", $location, 0);
            }
        }
        $query = "INSERT INTO buyer(name,address) VALUES('$buyer_name','$buyer_address')";
        $result = mysqli_query($conn, $query);
    }
    if (isset($_POST['customer_insert'])){
        $customer_first_name = $_POST['customer_first_name'];
        $customer_last_name = $_POST['customer_last_name'];
        $customer_address = $_POST['customer_address'];
        $query = "INSERT INTO customer(first_name,last_name,address) VALUES('$customer_first_name','$customer_last_name','$customer_address')";
        $result = mysqli_query($conn, $query);
    }
    if (isset($_POST['default_insert'])){
        $customer_id = $_POST['customer_id_select'];
        $stock_id = $_POST['stock_id_select'];
        $default_amount = $_POST['default_amount'];
        $query = "INSERT INTO defaulter(customer_id,stock_id,amount) VALUES('$customer_id','$stock_id','$default_amount')";
        $result = mysqli_query($conn, $query);
    }
    if (isset($_POST['expense_insert'])){
        $buyer_id = $_POST['buyer_id_select'];
        $stock_id = $_POST['stock_id_select'];
        $quantity = $_POST['quantity_expense'];
        $expense_date = $_POST['expense_date'];
        $query = "SELECT quantity, unit_cost FROM stock WHERE stock_id LIKE '$stock_id'";
        $result = mysqli_query($conn, $query);
        $first_row = mysqli_fetch_assoc($result);
        $quantity_on_hand = $first_row['quantity'];
        $unit_cost = $first_row['unit_cost'];
        $total_cost = $unit_cost * $quantity;
        $query = "INSERT INTO expense(buyer_id,stock_id,cost,expense_date) VALUES('$buyer_id','$stock_id','$total_cost','$expense_date')";
        $result = mysqli_query($conn, $query);
        $new_quant = $quantity_on_hand + $quantity;
        $query = "UPDATE stock SET quantity = '$new_quant' WHERE stock_id LIKE '$stock_id'";
        $result = mysqli_query($conn, $query);
    }
    if (isset($_POST['revenue_insert'])){
        $customer_id = $_POST['customer_id_select'];
        $stock_id = $_POST['stock_id_select'];
        $quantity = $_POST['quantity_revenue'];
        $processed = isset($_POST['processed']) ? 1 : 0;
        $revenue_date = $_POST['revenue_date'];
        $query = "SELECT quantity, unit_price FROM stock WHERE stock_id LIKE '$stock_id'";
        $result = mysqli_query($conn, $query);
        $first_row = mysqli_fetch_assoc($result);
        $unit_price = $first_row['unit_price'];
        $quantity_of_stock = $first_row['quantity'];

        if ($quantity > $quantity_of_stock){
            echo "Not enough items in stock";
        }
        else{
            $total_revenue = $quantity * $unit_price;
            $query = "INSERT INTO revenue(customer_id,stock_id,payment,status,revenue_date) VALUES('$customer_id','$stock_id','$total_revenue','$processed','$revenue_date')";
            $result = mysqli_query($conn, $query);
            $quantity_of_stock -= $quantity;
            $query = "UPDATE stock SET quantity = '$quantity_of_stock' WHERE stock_id LIKE '$stock_id'";
            $result = mysqli_query($conn, $query);
        }
    }
    if (isset($_POST['stock_insert'])){
        $name_of_stock = $_POST['name_of_stock'];
        $quantity_of_stock = $_POST['quantity_of_stock'];
        $min_quantity_of_stock = $_POST['min_quantity_of_stock'];
        $unit_price = $_POST['unit_price'];
        $unit_cost = $_POST['unit_cost'];
        $query = "INSERT INTO stock(name,quantity,min_quantity,unit_price,unit_cost) VALUES('$name_of_stock','$quantity_of_stock','$min_quantity_of_stock','$unit_price','$unit_cost')";
        $result = mysqli_query($conn, $query);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>WholeSale</title>
</head>
<body>
    <?php 
        $query = "SELECT * FROM buyer";
        $table = mysqli_query($conn, $query);
        echo "<table><tr><th>Buyer ID</th><th>Buyer Name</th><th>Buyer Address</th></tr>";
        while($row = mysqli_fetch_assoc($table)){
            echo "<tr><td>" . $row['buyer_id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['address'] . "</td></tr>";
        }
        echo "</table>";
    ?>
    <form action="main.php" method="post">
        <input type="text" name="buyer_name" placeholder="Distributor Name">
        <input type="text" name="buyer_address" placeholder="Distributor Address">
        <input type="submit" name="buyer_insert" value="INSERT">
    </form>
    <?php 
        $query = "SELECT * FROM customer";
        $table = mysqli_query($conn, $query);
        echo "<table><tr><th>Customer ID</th><th>First Name</th><th>Last Name</th><th>Address</th></tr>";
        while($row = mysqli_fetch_assoc($table)){
            echo "<tr><td>" . $row['customer_id'] . "</td><td>" . $row['first_name'] . "</td><td>" . $row['last_name'] . "</td>" . "<td>" . $row['address'] . "</td>" . "</tr>";
        }
        echo "</table>";
    ?>
    <form action="main.php" method="post">
        <input type="text" name="customer_first_name" placeholder="First Name">
        <input type="text" name="customer_last_name" placeholder="Last Name">
        <input type="text" name="customer_address" placeholder="Address">
        <input type="submit" name="customer_insert" value="INSERT">
    </form>
    <?php 
        $query = "SELECT * FROM defaulter";
        $table = mysqli_query($conn, $query);
        echo "<table><tr><th>Defaulter ID</th><th>Customer ID</th><th>Stock ID</th><th>Amount</th></tr>";
        while($row = mysqli_fetch_assoc($table)){
            echo "<tr><td>" . $row['default_id'] . "</td><td>" . $row['customer_id'] . "</td><td>" . $row['stock_id'] . "</td>" . "<td>" . $row['amount'] . "</td>" . "</tr>";
        }
        echo "</table>";
    ?>
    <form action="main.php" method="post">
        <label for="customer_select">Select Customer ID: </label>
        <select name="customer_id_select" id="customer_select">
            <?php 
                echoCustomer();
            ?>
        </select>
        <label for="stock_select">Select Stock ID: </label>
        <select name="stock_id_select" id="stock_select">
            <?php 
                echoStock();
            ?>
        </select>
        <label for="amount">Amount Default:</label>
        <input type="number" step="0.01" name="default_amount" id="amount" placeholder="$0.00">
        <input type="submit" name="default_insert" value="INSERT">
    </form>
    <?php 
        $query = "SELECT * FROM expense";
        $table = mysqli_query($conn, $query);
        echo "<table><tr><th>Expense ID</th><th>Buyer ID</th><th>Stock ID</th><th>Cost</th><th>Expense Date</th></tr>";
        while($row = mysqli_fetch_assoc($table)){
            $expense_id = $row['expense_id'];
            $buyer_id = $row['buyer_id'];
            $stock_id = $row['stock_id'];
            $cost = $row['cost'];
            $expense_date = $row['expense_date'];
            echo "<tr><td>$expense_id</td><td>$buyer_id</td><td>$stock_id</td><td>$cost</td><td>$expense_date</td></tr>";
        }
        echo "</table>";
    ?>
    <form action="main.php" method="post">
        <label for="buyer_select">Select Buyer ID: </label>
        <select name="buyer_id_select" id="buyer_select">
            <?php 
                echoBuyer();
            ?>
        </select>
        <label for="stock_select">Select Stock ID: </label>
        <select name="stock_id_select" id="stock_select">
            <?php 
                echoStock();
            ?>
        </select>
        <label for="quantity">Qty: </label>
        <input type="number" step="1" name="quantity_expense" id="quantity" placeholder="0" min="0">
        <input type="date" name="expense_date">
        <input type="submit" name="expense_insert" value="INSERT">
    </form>
    <?php 
        $query = "SELECT * FROM revenue";
        $table = mysqli_query($conn, $query);
        echo "<table><tr><th>Revenue ID</th><th>Customer ID</th><th>Stock ID</th><th>Payment</th><th>Status</th><th>Revenue Date</th></tr>";
        while($row = mysqli_fetch_assoc($table)){
            $revenue_id = $row['revenue_id'];
            $customer_id = $row['customer_id'];
            $stock_id = $row['stock_id'];
            $payment = $row['payment'];
            $status = $row['status'] ? "Paid": "Pending";
            $revenue_date = $row['revenue_date'];
            echo "<tr><td>$revenue_id</td><td>$customer_id</td><td>$stock_id</td><td>$payment</td><td>$status</td><td>$revenue_date</td></tr>";
        }
        echo "</table>";
    ?>
    <form action="main.php" method="post">
        <label for="customer_select">Select Customer ID: </label>
        <select name="customer_id_select" id="customer_select">
            <?php 
                echoCustomer();
            ?>
        </select>
        <label for="stock_select">Select Stock: </label>
        <select name="stock_id_select" id="stock_select">
            <?php 
                echoStock();
            ?>
        </select>
        <label for="quantity">Qty</label>
        <input type="number" step="1" name="quantity_revenue" id="quantity" placeholder="0" min="0">
        <label for="processed">Processed: </label>
        <input type="checkbox" name="processed" id="processed">
        <label for="revenue_date">Revenue Date: </label>
        <input type="date" name="revenue_date" id="revenue_date">
        <input type="submit" name="revenue_insert" value="INSERT">
    </form>
    <?php 
        $query = "SELECT * FROM stock";
        $table = mysqli_query($conn, $query);
        echo "<table><tr><th>Stock ID</th><th>Name</th><th>Quantity</th><th>Min Quantity</th><th>Unit Price</th><th>Unit Cost</th></tr>";
        while($row = mysqli_fetch_assoc($table)){
            $stock_id = $row['stock_id'];
            $name = $row['name'];
            $quantity = $row['quantity'];
            $min_quantity = $row['min_quantity'];
            $unit_price = $row['unit_price'];
            $unit_cost = $row['unit_cost'];
            echo "<tr><td>$stock_id</td><td>$name</td><td>$quantity</td><td>$min_quantity</td><td>$unit_price</td><td>$unit_cost</td></tr>";
        }
        echo "</table>";
    ?>
    <form action="main.php" method="post">
        <input type="text" name="name_of_stock" placeholder="Item Name">
        <label for="quantity_of_stock">Qty: </label>
        <input type="number" step="1" name="quantity_of_stock" placeholder="Qty" min="0" id="quantity_of_stock">
        <label for="min_quantity_of_stock">Min Qty: </label>
        <input type="number" step="1" name="min_quantity_of_stock" placeholder="Min Qty" min="0" id="min_quantity_of_stock">
        <label for="unit_price">Unit Price: </label>
        <input type="number" step="0.01" name="unit_price" placeholder="0.00" id="unit_price">
        <label for="unit_cost">Unit Cost: </label>
        <input type="number" step="0.01" name="unit_cost" placeholder="0.00" id="unit_cost"> <br>
        <input type="submit" name="stock_insert" value="INSERT">
    </form>
    <br>
    <form action="calculations.php" method="post">
        <h2>CHECK paid or pending: </h2><br>
        <input type="radio" name="status" id="Paid" value="1" required>Paid<br>
        <input type="radio" name="status" id="Pending" value="0" required>Pending<br>
        <input type="submit" name="check_button_paid_pending" value="CHECK">
    </form>
    <form action="calculations.php" method="post">
        <h2>Profit for a period of time: </h2>
        <label for="begin_date">Begin Date: </label>
        <input type="date" name="begin_date" id="begin_date">
        <label for="end_date">End Date: </label>
        <input type="date" name="end_date" id="end_date">
        <input type="submit" name="calculate_profit" value="CALCULATE">
    </form>
    <form action="calculations.php" method="post">
        <h2>Calculate stock that needs to be bought: </h2>
        <input type="submit" name="calculate_stock_to_buy" value="CALCULATE">
    </form>
</body>
</html>
