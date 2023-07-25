<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: index.php");
}

if (isset($_POST["resetPassword"])) {
  $password = mysqli_real_escape_string($conn, md5($_POST["new_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["cnew_password"]));
  if ($password === $cpassword) {
    $sql = "UPDATE users SET password='$password' WHERE token='{$_GET["token"]}'";
    mysqli_query($conn, $sql);
    header("Location: registration-user.php");
  } else {
    echo "<script>alert('Password not matched.');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/registration-user.css" />
  <link rel="icon" type="image/png" href="img/symbol2.png">
  <title> Raj Textiles and Engineers | Reset Password </title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="post" class="sign-in-form">
          <h2 class="title"> Raj Textiles and Engineers</h2>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="New Password" name="new_password" value="<?php echo $_POST['new_password']; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm New Password" name="cnew_password" value="<?php echo $_POST['cnew_password']; ?>" required />
          </div>
          <input type="submit" value="Reset Password" name="resetPassword" class="btn solid" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Reset Password?</h3>
          <p>
            Now you can create a new password.
          </p>
        </div>
        <img src="img/resetpass.png" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="js/app.js"></script>
</body>

</html>