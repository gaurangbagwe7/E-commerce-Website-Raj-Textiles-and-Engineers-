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

//to change details of user
if (isset($_POST['update_profile'])) {
  $update_full_name = mysqli_real_escape_string($conn, $_POST['update_full_name']);
  $update_mobile_number = mysqli_real_escape_string($conn, $_POST['update_mobile_number']);
  $update_address = mysqli_real_escape_string($conn, $_POST['update_address']);

  mysqli_query($conn, "UPDATE `users` SET full_name = '$update_full_name', mobile_number = '$update_mobile_number', address = '$update_address' WHERE id = '$user_id'") or die('query failed');
}

//to upload an image
if (isset($_POST['update_profile'])) {
  if (empty($path)) {
    $path = "img/default-image.png";
  }
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_error = $_FILES['image']['error'];
    $photo_new_name = rand() . $image;

    // do some validation or error checking here
    move_uploaded_file($image_tmp, "uploads/{$photo_new_name}");
    $path = "uploads/{$photo_new_name}";
    $sql = "UPDATE users SET image='$path' WHERE id= '$user_id'";
    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('Profile updated successfully.');</script>";
    }
  }
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/edit-profile.css" />
  <link rel="icon" type="image/png" href="img/symbol2.png">
  <title> Raj Textiles and Engineers | Edit Profile </title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="post" enctype="multipart/form-data" class="sign-in-form">
          <h2 class="title">
            <div class="upload" style="margin-bottom: -50px;">
              <img style="display:block;" src="<?php echo $image; ?>" id="image-preview" width=100 height=100 alt="">
              <div class="round">
                <input type="file" name="image" id="image" accept="image/*">
                <i class="fa fa-camera"
                  style="color: #fff;font-size: 20px; position: absolute;right: 5.5px; top: 6px;"></i>
              </div>
            </div> </br>
            <?php
            echo "Welcome, " . $full_name;
            ?>
          </h2>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Full Name" name="update_full_name" value="<?php echo $full_name; ?>" />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email Address" name="update_email" value="<?php echo $email; ?>"
              readonly />
          </div>
          <div class="input-field">
            <i class="fas fa-mobile"></i>
            <input type="tel" placeholder="Mobile Number" name="update_mobile_number"
              value="<?php echo $mobile_number; ?>" />
          </div>
          <div class="input-field">
            <i class="fas fa-address-book"></i>
            <input type="text" placeholder="Address" name="update_address" value="<?php echo $Address;
            mysqli_close($conn); ?>">
          </div>
          <input type="submit" value="Update" name="update_profile" id="update_profile" class="btn solid" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Update Profile?</h3>
          <p>
            Update your profile here.
          </p>
          <button class="btn transparent">
            <a style="padding: 10px" href="index.php">back</a>
          </button>
        </div>
        <img src="img/update.png" class="image" alt="" />
      </div>
    </div>

    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="js/edit-profile.js"></script>
</body>

</html>