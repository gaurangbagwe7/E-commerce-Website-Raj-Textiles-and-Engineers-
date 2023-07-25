<?php
  include 'config.php';
  session_start();
  error_reporting(0);

  // Get the product ID from the GET request
  $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);

  // Delete the product from the cart table
  $query = "DELETE FROM cart WHERE product_id = $product_id AND user_id = {$_SESSION['user_id']}";
  $result = mysqli_query($conn, $query);

  // Redirect the user back to the cart page
  header("Location: checkout.php");
?>
