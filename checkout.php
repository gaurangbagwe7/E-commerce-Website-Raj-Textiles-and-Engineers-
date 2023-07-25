<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: registration-user.php");
}

$user_id = $_SESSION['user_id']; // Replace with the actual user id
$sql = "SELECT full_name, email, mobile_number, Address, image FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $full_name = $row["full_name"];
        $email = $row["email"];
        $mobile_number = $row["mobile_number"];
        $Address = $row["Address"];
        $image = $row["image"];
        if (empty($image)) {
            $image = "img/default-image.png"; // this image will be displayed if their is no image in database
        }
    }
} else {
    echo "0 results";
}

//calclation
$user_id = $_SESSION['user_id'];
$query = "SELECT SUM(quantity) as cart_count FROM cart WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$cart_count = mysqli_fetch_assoc($result)['cart_count'];

$sub_total = 0.00;
$tax = 0.00;
$shipping = 0.00;
$total = 0.00;

$query = "SELECT products.id, products.product_name, products.price, products.product_image, SUM(cart.quantity) as total_quantity
                                    FROM products
                                    JOIN cart
                                    ON products.id = cart.product_id
                                    WHERE cart.user_id = {$_SESSION['user_id']}
                                    GROUP BY products.id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $product_price = $row['price'];
    $quantity = $row['total_quantity'];
    $sub_total += $product_price * $quantity;
    // Calculate tax
    $tax = $sub_total * 0.12;
    //calculate shipping
    if ($cart_count <= 2) {
        $shipping = 60;
    } elseif ($cart_count <= 5) {
        $shipping = 40;
    } else {
        $shipping = 0;
    }
    //calculate total
    $total = $sub_total + $tax + $shipping;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raj Textiles and Engineers | Checkout</title>
    <link rel="icon" type="image/png" href="img/symbol2.png">
    <link rel="stylesheet" href="css/checkout.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Source+Sans+3:200,300,regular,500,600,700,800,900,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">
            <img style="width: 100%;" src="img/logo.png" alt="">
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img style="width: 100%;" src="img/logo.png" alt="">
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
                    <a href="checkout.php">Cart<span style="padding-left: 5px;">
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
    <main class="container">
        <h1 class="heading">
            <ion-icon name="cart-outline"></ion-icon> Shopping Cart
        </h1>
        <div class="item-flex">

            <section class="checkout">
                <h2 class="section-heading">Payment Details</h2>
                <div class="payment-form">
                    <?php
                    if (isset($_POST['cash_on_delivery'])) {
                        // Get the user's ID
                        $user_id = $_SESSION['user_id'];

                        // Get the user's name, address, and mobile number
                        $user_query = "SELECT full_name, address, mobile_number FROM users WHERE id='$user_id'";
                        $user_result = mysqli_query($conn, $user_query);
                        $user_data = mysqli_fetch_assoc($user_result);

                        // Get the order details from the cart
                        $cart_query = "SELECT product_id, quantity FROM cart WHERE user_id='$user_id'";
                        $cart_result = mysqli_query($conn, $cart_query);

                        // Initialize the total price
                        $total_price = 0;

                        // Create an empty array to store the order items
                        $order_items = array();

                        // Loop through the cart items
                        while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                            // Get the product ID and quantity
                            $product_id = $cart_item['product_id'];
                            $quantity = $cart_item['quantity'];

                            // Get the product data from the products table
                            $product_query = "SELECT product_name, price FROM products WHERE id='$product_id'";
                            $product_result = mysqli_query($conn, $product_query);
                            $product_data = mysqli_fetch_assoc($product_result);

                            // Calculate the subtotal for this product
                            $subtotal = $product_data['price'] * $quantity;

                            // Add the subtotal to the total price
                            $total_price += $subtotal;

                            // Push a new array containing the product ID, name, and quantity onto the order_items array
                            $order_items[] = array('product_id' => $product_id, 'name' => $product_data['product_name'], 'quantity' => $quantity);
                        }
                        // calculate shipping price
                        $query = "SELECT SUM(quantity) as cart_count FROM cart WHERE user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        $cart_count = mysqli_fetch_assoc($result)['cart_count'];
                        if ($cart_count <= 2) {
                            $shipping_price = 60;
                        } elseif ($cart_count <= 5) {
                            $shipping_price = 40;
                        } else {
                            $shipping_price = 0;
                        }
                        // calculate tax
                        $tax = $total_price * 0.12;
                        $total_price += $tax + $shipping_price;

                        // Insert the order into the orders table
                        $insert_query = "INSERT INTO orders (user_id, full_name, address, mobile_number, total_price, payment_type) VALUES ('$user_id', '" . $user_data['full_name'] . "', '" . $user_data['address'] . "', '" . $user_data['mobile_number'] . "', '$total_price', 'Cash on Delivery')";
                        $result = mysqli_query($conn, $insert_query);
                        $order_id = mysqli_insert_id($conn);

                        // Insert the order items into the order_items table
                        foreach ($order_items as $item) {
                            $product_id = $item['product_id'];
                            $product_name = $item['name'];
                            $quantity = $item['quantity'];

                            $insert_item_query = "INSERT INTO order_items (order_id, product_id, product_name, quantity) VALUES ('$order_id', '$product_id', '$product_name', '$quantity')";
                            mysqli_query($conn, $insert_item_query);
                        }


                        // Clear the cart
                        $clear_cart_query = "DELETE FROM cart WHERE user_id='$user_id'";
                        mysqli_query($conn, $clear_cart_query);

                        // Redirect to the order confirmation page
                        echo "<script>window.location.href='your-orders.php'</script>";
                        exit();
                    }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data" class="sign-in-form">
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input style="cursor: pointer;" type="text" placeholder="Full Name" name="update_full_name"
                                value="<?php echo $full_name; ?>" required readonly />
                        </div>
                        <div class="input-field">
                            <i class="fas fa-mobile"></i>
                            <input style="cursor: pointer;" type="tel" placeholder="Mobile Number"
                                name="update_mobile_number" value="<?php echo $mobile_number; ?>" required readonly />
                        </div>
                        <div class="input-field" style="width: 100%;">
                            <i class="fas fa-address-book"></i>
                            <input style="cursor: pointer;" type="text" placeholder="Address" name="update_address"
                                value="<?php echo $Address; ?>" required readonly />
                        </div>
                        <button class="btn btn-primary" name=cash_on_delivery>
                            <b> cash on delivery </b> ₹
                            <?php echo $total; ?>
                        </button>
                    </form>
            </section>

            <section class="cart">
                <div class="cart-item-box">
                    <h2 class="section-heading">Order Summery</h2>
                    <!--one item -->
                    <?php
                    $user_id = $_SESSION['user_id'];
                    if ($cart_count == 0) {
                        echo '<p style="text-align: center;">Your cart is currently empty</p>';
                    } else {

                        // Get the items in the cart for the current user
                        $query = "SELECT products.id, products.product_name, products.price, products.product_image, SUM(cart.quantity) as total_quantity
                FROM products
                JOIN cart
                ON products.id = cart.product_id
                WHERE cart.user_id = {$_SESSION['user_id']}
                GROUP BY products.id";

                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="product-card">';
                            echo '<div class="card">';
                            echo '<div class="img-box">';
                            echo '<img src="' . $row['product_image'] . '" alt="" width="80px" class="product-img">';
                            echo '</div>';
                            echo '<div class="detail">';
                            echo '<h4 class="product-name">' . $row['product_name'] . '</h4>';
                            echo '<div class="wrapper">';

                            echo '<div class="product-qty">';
                            echo '<form method="post" action="update-quantity.php">
                            <button div class="product-qty" type="submit" name="decrement"><ion-icon name="remove-outline"></ion-icon></button>
                            <input type="hidden" name="product_id" value="' . $row['id'] . '">
                            <input type="number" class="input-quantity" name="quantity" value=' . $row['total_quantity'] . ' min="1" readonly>
                            <button type="submit" name="increment"><ion-icon name="add-outline"></ion-icon></button>
                        </form>';
                            echo '</div>';

                            echo '<div class="price">';
                            echo '₹ <span id="price">' . $row['price'] . '</span>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<form action="remove-from-cart.php" method="get">
                        <input type="hidden" name="product_id" value="' . $row['id'] . '">
                        <button class="product-close-btn" type="submit" name="remove"><ion-icon name="close-outline"></ion-icon></button>
                        </form>';
                            echo '</div>';
                            echo '</div>';
                        }
                        echo '<p style="text-align: center; padding-top: 30px;">Expected delivery within 7 days</p>';
                    }
                    ?>
                    <!--End of one item-->

                </div>
                <div class="amount">
                    <div class="subtotal">
                        <span>Subtotal</span> <span>₹ <span id="subtotal">
                                <?php echo $sub_total; ?>
                            </span></span>
                    </div>

                    <div class="tax">
                        <span>Tax</span> <span>₹ <span id="tax">
                                <?php echo $tax; ?>
                            </span></span>
                    </div>

                    <div class="shipping">
                        <span>Shipping</span> <span>₹ <span id="shipping">
                                <?php echo $shipping; ?>
                            </span></span>
                    </div>

                    <div class="total">
                        <span>Total</span> <span>₹ <span id="total">
                                <?php echo $total; ?>
                            </span></span>
                    </div>
                </div>
        </div>
        </section>
        </div>
    </main>

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

    <script type="text/javascript" src="js/products.js"></script>
    <script type="text/javascript" src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.3/gsap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>