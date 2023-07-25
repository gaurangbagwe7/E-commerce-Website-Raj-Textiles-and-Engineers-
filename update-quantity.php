<?php
include 'config.php';
session_start();
    $quantity = $_POST["quantity"];

    if(isset($_POST["increment"])) {
        $quantity++;
    } elseif(isset($_POST["decrement"])) {
        if($quantity > 1) {
            $quantity--;
        }
    }

    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    $update_quantity_query = "UPDATE cart SET quantity = '$quantity' WHERE product_id = '$product_id'";
$update_quantity_result = mysqli_query($conn, $update_quantity_query);
  header("Location: checkout.php");
?>
