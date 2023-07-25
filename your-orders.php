<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: registration-user.php");
}

$user_id = $_SESSION['user_id']; // Replace with the actual user id
$sql = "SELECT full_name, image FROM users WHERE id='$user_id'";
$result1 = mysqli_query($conn, $sql);

if (mysqli_num_rows($result1) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result1)) {
        $full_name = $row["full_name"];
        $image = $row["image"];
        if (empty($image)) {
            $image = "img/default-image.png"; // this image will be displayed if their is no image in database
        }
    }
} else {
    echo "0 results";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UFT-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat&amp;display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="img/symbol2.png">
    <link rel="stylesheet" href="css/your-orders.css">
    <title>Raj Textiles and Engineers | Your Orders</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="">
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="img/logo.png" alt="">
            </div>
            <ul>
                <li>
                    <a href="index.php" class="active">Home</a>
                </li>
                <li>
                    <a href="products.php">Products</a>
                </li>
                <li>
                    <a href="index.php#features">Services</a>
                </li>
                <li>
                    <a href="index.php#about" id="scroll-to-about">About</a>
                </li>
                <li>
                    <a href="checkout.php">Cart<span style="padding: 5px;">
                            <?php
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $query = "SELECT SUM(quantity) as cart_count FROM cart WHERE user_id = '$user_id'";
                                $result = mysqli_query($conn, $query);
                                $cart_count = mysqli_fetch_assoc($result)['cart_count'];
                                if (!empty($cart_count)) {
                                    echo $cart_count;
                                } else {
                                    echo '0';
                                }
                            }
                            ?>
                        </span></a>
                </li>
                <li>
                    <div class="profile-dropdown">
                        <div class="profile-dropdown-btn" onclick="toggle()">
                            <div class="profile-img">
                                <img src="<?php echo $image; ?>">
                                <i class="fa-solid fa-circle"></i>
                            </div>
                            <span>
                                <?php echo $full_name;
                                ?>
                                <i class="fa-solid fa-angle-down"></i>
                            </span>
                        </div>

                        <ul class="profile-dropdown-list">
                            <li class="profile-dropdown-list-item">
                                <a href="edit-profile.php">
                                    <i class="fa-regular fa-user"></i>
                                    Edit Profile
                                </a>
                            </li>
                            <li class="profile-dropdown-list-item">
                                <a href="your-orders.php">
                                    <i class="fas fa-suitcase"></i>
                                    Your Orders
                                </a>
                            </li>
                            <hr />
                            <li class="profile-dropdown-list-item">
                                <a href="logout.php">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>
    <h1 class="lg-title">Your Orders</h1>


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
        header("Location: your-orders.php?id=$order_id");
    }

    // Get the user's ID
    $user_id = $_SESSION['user_id'];
    $query = "SELECT orders.id, orders.date, orders.full_name, orders.address, orders.mobile_number, orders.status,
GROUP_CONCAT(order_items.product_name SEPARATOR '</br>') as product_name, 
GROUP_CONCAT(order_items.quantity SEPARATOR '</br> x ') as quantity,
orders.total_price, orders.payment_type
FROM orders
JOIN order_items ON orders.id = order_items.order_id
WHERE orders.user_id = '$user_id'
GROUP BY orders.id ORDER BY orders. Date DESC";
    // Execute the query and get the result
    $result = mysqli_query($conn, $query);
    // Print the order information
    if (mysqli_num_rows($result) == 0) {
        echo '<p style="text-align: center; padding-top: 225px;">There are no orders placed</p>';
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="details">';
            echo '<div class="recentOrders">';
            echo '<table>';
            echo '<tbody>';
            echo '<tr>';
            echo '<td>Date:</td>';
            echo '<td colspan="2">' . $row['date'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Name:</td>';
            echo '<td colspan="2">' . $row['full_name'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Address:</td>';
            echo '<td colspan="2">' . $row['address'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Mobile Number:</td>';
            echo '<td colspan="2">' . $row['mobile_number'] . '</td>';
            echo '</tr>';


            echo '<tr>';
            echo '<td style="width: 390px;">Order Items:</td>';
            echo '<td style="width: 115px;">' . $row['product_name'] . '</td>';
            echo '<td colspan="2" style="display: flex; width: 42px;">x ' . $row['quantity'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Price:</td>';
            echo '<td colspan="2">₹' . $row['total_price'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Payment:</td>';
            echo '<td colspan="2">' . $row['payment_type'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Status:</td>';
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
            echo '</tr>';
            echo '<tr>';
            echo '<td class="cancel-btn">';
            echo '<form method="post" class="hidden form">';
            echo '<input type="hidden" name="order_id" value="' . $row['id'] . '" />';
            echo '<input type="hidden" name="status" id="status" value="Cancel" />';

            if ($row['status'] == "Pending") {
                echo '<button class="btn-form" type="submit" name="update_status"> Cancel </button>';
            } else {
                echo '<button class="btn-form-disabled" type="submit" name="update_status" disabled> Cancel </button>';
            }
            echo '</form>';
            echo '</td>';
            echo '</td>';
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>

    <!------------------------------------------------------------------------------------------------------------------------------------------>
    <!--Footer-->

    <footer class="footer-distributed">

        <div class="footer-left">
            <h3>Raj Textiles and Engineers</h3>

            <p class="footer-links">
                <a href="index.php">Home</a>
                |
                <a href="products.php">Products</a>
                |
                <a href="#">Services</a>
                |
                <a href="index.php#about" id="scroll-to-about">About</a>
            </p>

            <p class="footer-company-name">Copyright © 2021 <strong>RajTextilesAndEngineers</strong> All rights reserved
            </p>
        </div>

        <div class="footer-center">
            <div>
                <i class="fa fa-map-marker"></i>
                <p><span>Bhiwandi</span>
                    Maharashtra - 421302</p>
            </div>

            <div>
                <i class="fa fa-phone" style="transform: rotate(90deg);"></i>
                <p>+91 9320512792</p>
            </div>
            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="mailto:kushagrbakshi12@gmail.com">support@raj.textiles.com</a></p>
            </div>
        </div>
        <div class="footer-right">
            <p class="footer-company-about">
                <span>About the company</span>
                <strong>Raj Textiles and Engineers</strong> is a company that specializes in the sale of textile machines and provides
          services related to the textile industry. We offer a range of machines for different textile
          manufacturing processes, such as spinning, weaving, and finishing. Additionally, we may also provide
          maintenance and repair services for textile machines. We are a one stop solution for all textile needs.
            </p>
            <div class="footer-icons">
                <a href="https://www.linkedin.com/in/rajkumar-bakshi-7a4a67118/?originalSubdomain=in"><i
                        class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script type="text/javascript" src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.3/gsap.min.js"></script>
    <script type="text/javascript" src="js/products.js"></script>
    <script type="text/javascript" src="js/your-orders.js"></script>

</body>

</html>