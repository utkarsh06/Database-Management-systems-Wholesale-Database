<?php 
include "connect.php";

function echoCustomer(){
    global $conn;
    $query = "SELECT customer_id FROM customer";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)){
    $id = $row['customer_id'];
    echo "<option value='$id'>$id</option>";
    }
}

function echoStock() {
    global $conn;
    $query = "SELECT stock_id FROM stock";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['stock_id'];
        echo "<option value='$id'>$id</option>";
    }
}

function echoBuyer(){
    global $conn;
    $query = "SELECT buyer_id FROM buyer";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['buyer_id'];
        echo "<option value='$id'>$id</option>";
    }
}
?>