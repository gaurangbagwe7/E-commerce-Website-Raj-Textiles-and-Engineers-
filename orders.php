<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: registration-user.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raj Textiles and Engineers | Orders</title>
    <link rel="icon" type="image/png" href="img/symbol2.png">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/orders.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <img style="height: 50px; width: 50px; border-radius: 50%; padding: 5px; top: 5px; position: absolute; right: 5px"
                                src="img/symbol.png">
                        </span>
                        <span class="title">Raj Textiles and Engineers</span>
                    </a>
                </li>

                <li>
                    <a href="dashboard.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="add-products.php">
                        <span class="icon">
                            <ion-icon name="add-circle"></ion-icon>
                        </span>
                        <span class="title">Add Products</span>
                    </a>
                </li>

                <li>
                    <a href="orders.php">
                        <span class="icon">
                            <ion-icon name="car-outline"></ion-icon>
                        </span>
                        <span class="title">Orders</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>
            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div style="display: block;" class="recentOrders">
                    <div class="cardHeader">
                        <h2>All Orders</h2>
                    </div>
                    <?php
                    if (isset($_POST['update_status'])) {
                        // Get the order ID and new status from the form
                        $order_id = $_POST['order_id'];
                        $status = $_POST['status'];

                        // Create the update query
                        $query = "UPDATE orders SET status='$status' WHERE id='$order_id'";

                        // Execute the query
                        mysqli_query($conn, $query);

                        // Redirect the admin to the order details page
                        header("Location: orders.php?id=$order_id");
                    }


                    // Get the user's ID
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT orders.id, orders.date, orders.full_name, orders.address, orders.mobile_number, orders.status,
GROUP_CONCAT(order_items.product_name SEPARATOR ', </br>') as product_name, 
GROUP_CONCAT(order_items.quantity SEPARATOR '</br>') as quantity,
orders.total_price, orders.payment_type
FROM orders
JOIN order_items ON orders.id = order_items.order_id
GROUP BY orders.id ORDER BY orders.date DESC";

                    // Execute the query and get the result
                    $result = mysqli_query($conn, $query);


                    // Print the order information
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<td>Date </td>';
                    echo '<td>Name </td>';
                    echo '<td>Address</td>';
                    echo '<td>Mobile Number</td>';
                    echo '<td>Product Name</td>';
                    echo '<td>Quantity</td>';
                    echo '<td>Price</td>';
                    echo '<td>Payment</td>';
                    echo '<td>Status</td>';
                    echo '<td>Actions</td>';
                    echo '</tr>';
                    echo '</thead>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' . $row['date'] . '</td>';
                        echo '<td>' . $row['full_name'] . '</td>';
                        echo '<td>' . $row['address'] . '</td>';
                        echo '<td>' . $row['mobile_number'] . '</td>';
                        echo '<td>' . $row['product_name'] . '</td>';
                        echo '<td>' . $row['quantity'] . '</td>';
                        echo '<td>₹' . $row['total_price'] . '</td>';
                        echo '<td>' . $row['payment_type'] . '</td>';

                        echo '<td>';
                        switch ($row['status']) {
                          case 'Pending':
                            echo '<span class="pending">' . $row['status'] . '</span>';
                            break;
                          case 'Delivered':
                            echo '<span class="delivered">' . $row['status'] . '</span>';
                            break;
                          case 'In Progress':
                            echo '<span class="in-progress">' . $row['status'] . '</span>';
                            break;
                          case 'Cancel':
                            echo '<span class="cancel">' . $row['status'] . '</span>';
                            break;
                          default:
                            echo $row['status'];
                        }
                        echo '</td>';

                        echo '<td>
                        <form method="post" class="hidden form">
                        <input type="hidden" name="order_id" value='.$row['id'].'>
                        <select name="status" id="status" class="status">
                        <option value="" disabled selected>Choose Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Delivered">Delivered</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Cancel">Cancel</option>
                        </select>
                        <button style="cursor: pointer; border: none; border-radius: 40%; margin: 5px;" type="submit" name="update_status"><i class="fas fa-check"></i></button>
                        </form>
                        </td>';

                        echo '</tr>';
                        echo '</tbody>';
                    }
                    echo '</table>';
                    ?>
                </div>
                <!-- =========== Scripts =========  -->
                <script src="js/dashboard.js"></script>
                <script src="js/orders.js"></script>

                <!-- ====== ionicons ======= -->
                <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
                <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>