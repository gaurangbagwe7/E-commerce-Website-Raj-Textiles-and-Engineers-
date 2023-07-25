<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: registration-user.php');
    exit();
}

error_reporting(0);

if (isset($_POST["add_products"])) {
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $discount_percent = mysqli_real_escape_string($conn, $_POST["discount_percent"]);
    $discount_price = mysqli_real_escape_string($conn, $_POST["discount_price"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);

    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];
    $product_image_size = $_FILES['product_image']['size'];
    $product_image_error = $_FILES['product_image']['error'];
    $photo_new_name = rand() . $product_image;
    move_uploaded_file($product_image_tmp, "products/{$photo_new_name}");
    $path = "products/{$photo_new_name}";

    $sql = "INSERT INTO products (product_name, price, discount_percent, discount_price, description, date, product_image) VALUES ('$product_name', '$price', '$discount_percent', '$discount_price', '$description', '$date', '$path')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profile updated successfully.');</script>";
    }
    header("Location: add-products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raj Textiles and Engineers | Add Products</title>
    <link rel="icon" type="image/png" href="img/symbol2.png">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/add-products.css">
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

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <form action="" method="post" enctype="multipart/form-data" class="sign-in-form">
                            <h2 class="title-form">
                                <div class="upload" style="margin-bottom: -50px;">
                                    <img style="display:block;" src="img/pimg.png" id="image-preview" width=100
                                        height=100 alt="">
                                    <div class="round">
                                        <input type="file" name="product_image" id="image" accept="image/*" required>
                                        <i class="fa fa-camera"
                                            style="color: #fff;font-size: 20px; position: absolute;right: 5.5px; top: 6px;"></i>
                                    </div>
                                </div> </br>
                                Add Products
                            </h2>
                            <div class="input-field">
                                <i class="fas fa-tshirt"></i>
                                <input type="text" placeholder="Product Name" name="product_name"
                                    value="<?php echo $_POST["product_name"]; ?>" required />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-rupee-sign"></i>
                                <input type="tel" placeholder="Price" name="price"
                                    value="<?php echo $_POST["price"]; ?>" required />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-percent"></i>
                                <input type="tel" placeholder="Discount Percent" name="discount_percent"
                                    value="<?php echo $_POST["discount_percent"]; ?>" />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-rupee-sign"></i>
                                <input type="tel" placeholder="Discount Price" name="discount_price"
                                    value="<?php echo $_POST["discount_price"]; ?>" />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-info-circle"></i>
                                <input type="text" placeholder="Description" name="description"
                                    value="<?php echo $_POST["description"]; ?>" required />
                            </div>
                            <div class="input-field">
                                <i class="fas fa-calendar"></i>
                                <input style="padding-top: 20px;" type="date" placeholder="Date" name="date" id="date"
                                    value="<?php echo $_POST["date"]; ?>" required />
                            </div>
                            <input type="submit" value="Add Products" name="add_products" id="add_products"
                                class="btn-form solid" />
                        </form>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Our Products</h2>
                    </div>
                    <?php
                    // Query all products from the database
                    $result = mysqli_query($conn, "SELECT * FROM products");
                    // Fetch the results as an associative array
                    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    mysqli_close($conn);

                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<td>Name</td>';
                    echo '<td>Description</td>';
                    echo '<td>Price</td>';
                    echo '<td>Discount Price</td>';
                    echo '<td>Discount Percent</td>';
                    echo '<td>Images</td>';
                    echo '<td>Actions</td>';
                    echo '</tr>';
                    echo '</thead>';
                    foreach ($data as $product) {
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' . $product['product_name'] . '</td>';
                        echo '<td>' . $product['description'] . '</td>';
                        echo '<td>₹' . $product['price'] . '</td>';
                        echo '<td>' . $product['discount_price'] . '</td>';
                        echo '<td>' . $product['discount_percent'] . '</td>';
                        echo '<td><img src="' . $product['product_image'] . '"></td>';
                        echo '<td>';
                        echo '<form action="delete.php" method="post">
                        <input type="hidden" name="id" value="' . $product['id'] . '">
                        <button style="cursor: pointer; border: none; border-radius: 40%; margin: 5px;" type="submit" name="delete"><i class="fas fa-trash"></i></button>
                        </form>';
                        echo '</td>';
                        echo '</tr>';
                        echo '</tbody>';
                    }
                    echo '</table>';
                    ?>
                </div>

                <!-- ================= New Customers ================ -->

            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="js/dashboard.js"></script>
    <script src="js/edit-profile.js"></script>
    <script src="js/add-products.js"></script>

    <!-- ====== ionicons ======= -->
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>