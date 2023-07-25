<?php
  include 'config.php';
  session_start();
  error_reporting(0);

  // Get the id from the query parameter or from the form input
  $id = $_GET['id']; //if you are using query parameter
  $id = $_POST['id']; //if you are using form input

  // Delete the data from the database
  $sql = "DELETE FROM products WHERE id='$id'";
  $result = mysqli_query($conn, $sql);
  if($result) {
    echo "<script>alert('Data deleted successfully');</script>";
  } else {
    echo "<script>alert('Error deleting data: " . mysqli_error($conn) . "');</script>";
  }

  // Close the connection
  mysqli_close($conn);
  header("Location: add-products.php");
    exit();
?>
