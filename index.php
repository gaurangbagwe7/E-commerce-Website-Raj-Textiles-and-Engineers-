<?php
include 'config.php';
session_start();
error_reporting(0);

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
}

//Add to cart
if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $user_id = $_SESSION['user_id'];

  // check if the product is already in the cart for that user
  if ($user_id > 0) {
    $query = "SELECT * FROM cart WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      // update the existing row with the new quantity
      $query = "UPDATE cart SET quantity = quantity + '$quantity' WHERE product_id = '$product_id' AND user_id = '$user_id'";
    } else {
      // insert a new row
      $query = "INSERT INTO cart (product_id, quantity, user_id) VALUES ('$product_id', '$quantity', '$user_id')";
    }

    $result2 = mysqli_query($conn, $query);
    header("Location: index.php");
    exit();
  } else {
    echo "<script>window.location.href='registration-user.php'</script>";
    exit();
  }
}

//buy now 
if (isset($_POST['buy_now'])) {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $user_id = $_SESSION['user_id'];

  // check if the product is already in the cart for that user
  if ($user_id > 0) {
    $query = "SELECT * FROM cart WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      // update the existing row with the new quantity
      $query = "UPDATE cart SET quantity = quantity + '$quantity' WHERE product_id = '$product_id' AND user_id = '$user_id'";
    } else {
      // insert a new row
      $query = "INSERT INTO cart (product_id, quantity, user_id) VALUES ('$product_id', '$quantity', '$user_id')";
    }

    $result2 = mysqli_query($conn, $query);
    header("Location: checkout.php");
    exit();
  } else {
    echo "<script>window.location.href='registration-user.php'</script>";
    exit();
  }
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
  <link rel="stylesheet" href="css/index.css">
  <title>Raj Textiles and Engineers | Welcome</title>
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
          <a id="scroll-to-features">Services</a>
        </li>
        <li>
          <a id="scroll-to-about">About</a>
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
          <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="profile-dropdown">
              <div class="profile-dropdown-btn" onclick="toggle()">
                <div class="profile-img">
                  <img src="<?php echo $image; ?>">
                  <i class="fa-solid fa-circle"></i>
                </div>
                <span>
                  <?php echo $full_name; ?>
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
          <?php } else { ?>
            <a href="registration-user.php">
              <i class="fa-solid fa-sign-in"></i>
              Login
            </a>
          <?php } ?>
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
  <!------------------------------------------------------------------------------------------------------------------------------------------>
  <!-- Slider -->
  <div class="app">
    <div class="cardList">
      <button class="cardList__btn btn btn--left">
        <div class="icon">
          <svg>
            <use xlink:href="#arrow-left"></use>
          </svg>
        </div>
      </button>

      <div class="cards__wrapper">
        <div class="card current--card">
          <div class="card__image">
            <img src="img/photo1.png" alt="" />
          </div>
        </div>

        <div class="card next--card">
          <div class="card__image">
            <img src="img/photo2.png" alt="" />
          </div>
        </div>

        <div class="card previous--card">
          <div class="card__image">
            <img src="img/photo3.png" alt="" />
          </div>
        </div>
      </div>

      <button class="cardList__btn btn btn--right">
        <div class="icon">
          <svg>
            <use xlink:href="#arrow-right"></use>
          </svg>
        </div>
      </button>
    </div>

    <div class="infoList">
      <div class="info__wrapper">
        <div class="info current--info">
          <h1 class="text name">Machine Maintenance</h1>
          <h4 class="text location"></h4>
          <p class="text description"></p>
        </div>

        <div class="info next--info">
          <h1 class="text name">Machine Installation</h1>
          <h4 class="text location"></h4>
          <p class="text description"></p>
        </div>

        <div class="info previous--info">
          <h1 class="text name">Technical Support</h1>
          <h4 class="text location"></h4>
          <p class="text description"></p>
        </div>
      </div>
    </div>


    <div class="app__bg">
      <div class="app__bg__image current--image">
        <img src="img/photo1.png" alt="" />
      </div>
      <div class="app__bg__image next--image">
        <img src="img/photo2.png" alt="" />
      </div>
      <div class="app__bg__image previous--image">
        <img src="img/photo3.png" alt="" />
      </div>
    </div>
  </div>

  <svg class="icons" style="display: none;">
    <symbol id="arrow-left" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
      <polyline points='328 112 184 256 328 400'
        style='fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px' />
    </symbol>
    <symbol id="arrow-right" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
      <polyline points='184 112 328 256 184 400'
        style='fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px' />
    </symbol>
  </svg>


  <!------------------------------------------------------------------------------------------------------------------------------------------>
  <!--Products-->
  <div class="products">
    <div class="container">
      <h1 class="lg-title">our new products</h1>
      <p class="text-light">we offer a wide range of high-quality textile products including bedding, outdoor fabrics,
        and custom made home decor items made of premium materials such as Egyptian cotton and linen.
      </p>

      <div class="product-items">
        <!-- single product -->
        <?php
        // Query all products from the database
        $result2 = mysqli_query($conn, "SELECT * FROM products ORDER BY date DESC LIMIT 8");
        // Fetch the results as an associative array
        $data = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        mysqli_close($conn);
        // Iterate through the products and print them
        foreach ($data as $product) {
          echo '<div class="product">';
          echo '<div class="product-content">';
          echo '<div class="product-img">';
          echo '<img src="' . $product['product_image'] . '" alt="product image">';
          echo '</div>';
          echo '<div class="product-btns">';

          echo '<button>';
          echo '<form action="" method="post" autocomplete="off">
          <input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '">
          <input type="hidden" name="product_id" value="' . $product['id'] . '">
          <input type="hidden" name="quantity" value="1" min="1">
          <button type="submit" name="add_to_cart" class="btn-cart" value="buy now">add to cart <span><i class="fas fa-plus"></i></span> </button>
          </form>';
          echo '</button>';

          echo '<form action="" method="post" autocomplete="off">
          <input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '">
          <input type="hidden" name="product_id" value="' . $product['id'] . '">
          <input type="hidden" name="quantity" value="1" min="1">
          <button type="submit" name="buy_now" class="btn-cart" value="buy now">buy now <span><i class="fas fa-shopping-cart"></i></span> </button>
          </form>';

          echo '</div>';
          echo '</div>';
          echo '<div class="product-info">';
          echo '<div class="product-info-top">';
          echo '<h2 class="sm-title">' . $product['product_name'] . '</h2>';
          echo '</div>';
          echo '<a href="#" class="product-name">' . $product['description'] . '</a>';
          if (!empty($product['discount_price'])) {
            echo '<p class="product-price">₹ ' . $product['price'] . '</p>';
          } else {
            echo '<p style="text-decoration: none;" class="product-price">₹ ' . $product['price'] . '</p>';
          }
          if (!empty($product['discount_price'])) {
            echo '<p class="product-price">₹ ' . $product['discount_price'] . '</p>';
          }
          echo '</div>';
          echo '<div class="off-info">';
          if (!empty($product['discount_price'])) {
            echo '<h2 class="sm-title">' . $product['discount_percent'] . '% off</h2>';
          }
          echo '</div>';
          echo '</div>';
        }
        ?>
        <!-- end of single product -->
      </div>
      <div style="text-align: center;">
        <button class="btn transparent"><a href="products.php"> View More </a></button>
      </div>
    </div>
  </div>

  <!------------------------------------------------------------------------------------------------------------------------------------------>
  <!--Services-->

  <section class="features" id="features">
    <h2>Why Choose Us?</h2>
    <p class="section-desc">
      With years of experience in the textile industry, at Raj Textiles and
      Engineers we have a deep understanding of the machines and services we provide,
      and can offer expert advice and support.
    </p>
    <div class="row">
      <div class="column">
        <i class="fa-solid fa-angles-down"></i>
        <h3>Machine Installation</h3>
        <p>
          Services to install and set up new textile machines, and provide training for operators.
        </p>
        <div style="text-align: center; padding: 20px;">
          <button class="contact-btn transparent"><a href="index.php#contact" style="padding: 10px"> contact us </a></button>
        </div>
      </div>

      <div class="column">
        <i class="fa-solid fa-map-location-dot"></i>
        <h3>Machine Relocation</h3>
        <p>
          Supply of replacement parts for textile machines, to minimize downtime and ensure smooth production.
        </p>
        <div style="text-align: center; padding: 20px;">
          <button class="contact-btn transparent"><a href="index.php#contact" style="padding: 10px"> contact us </a></button>
        </div>
      </div>

      <div class="column">
        <i class="fa-solid fa-screwdriver-wrench"></i>
        <h3>Maintenance</h3>
        <p>
          Regular inspections and maintenance to keep textile machines in good working order and prevent unexpected
          breakdowns.
        </p>
        <div style="text-align: center; padding: 20px;">
          <button class="contact-btn transparent"><a href="index.php#contact" style="padding: 10px"> contact us </a></button>
        </div>
      </div>

      <div class="column">
        <i class="fa-solid fa-hammer"></i>
        <h3>Machine Repair</h3>
        <p>
          Services to fix and repair textile machines when they break down or malfunction.
        </p>
        <div style="text-align: center; padding: 20px;">
          <button class="contact-btn transparent"><a href="index.php#contact" style="padding: 10px"> contact us </a></button>
        </div>
      </div>

      <div class="column">
        <i class="fa-solid fa-angles-up"></i>
        <h3>Machine Upgrades</h3>
        <p>
          Services to upgrade and modernize textile machines to improve efficiency and performance.
        </p>
        <div style="text-align: center; padding: 20px;">
          <button class="contact-btn transparent"><a href="index.php#contact" style="padding: 10px"> contact us </a></button>
        </div>
      </div>

      <div class="column">
        <i class="fa-solid fa-user-tie"></i>
        <h3>Technical Support</h3>
        <p>
          Expert advice and support for troubleshooting and solving technical issues with textile machines.
        </p>
        <div style="text-align: center; padding: 20px;">
          <button class="contact-btn transparent"><a href="index.php#contact" style="padding: 10px"> contact us </a></button>
        </div>
      </div>

    </div>
  </section>


  <!------------------------------------------------------------------------------------------------------------------------------------------>
  <!--About us-->

  <div id="about" class="wrapper">

    <div class="background-container">
      <div class="bg-1"></div>
      <div class="bg-2"></div>

    </div>
    <div class="about-container">

      <div class="image-container">
        <img src="./img/photo1.png" alt="">

      </div>

      <div class="text-container">
        <h1>About us</h1>
        <p>Raj Textiles and Engineers is a company that specializes in the sale of textile machines and provides
          services related to the textile industry. We offer a range of machines for different textile
          manufacturing processes, such as spinning, weaving, and finishing. Additionally, we may also provide
          maintenance and repair services for textile machines. We are a one stop solution for all textile needs.</p>

      </div>
    </div>
  </div>

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
        <a href="index.php#features">Services</a>
        |
        <a href="index.php#about" id="scroll-to-about">About</a>
      </p>

      <p class="footer-company-name">Copyright © 2021 <strong>RajTextilesAndEngineers</strong> All rights reserved</p>
    </div>

    <div class="footer-center">
      <div>
        <i class="fa fa-map-marker"></i>
        <p><span>Bhiwandi</span>
          Maharashtra - 421302</p>
      </div>

      <div>
        <i class="fa fa-phone" style="transform: rotate(90deg);"></i>
        <p id="contact">+91 9320512792</p>
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
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>