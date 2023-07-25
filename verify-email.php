<?php

session_start();
if (isset($_GET["token"])) {
    include 'config.php';
    $sql = "UPDATE users SET status='1' WHERE token='{$_GET["token"]}'";
    mysqli_query($conn, $sql);

    $showUserId = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE token='{$_GET["token"]}'"));
    $_SESSION["user_id"] = $showUserId['id'];

    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] == 1) {
            header('Location: dashboard.php');
        } else {
            header('Location: index.php');
        }
    } else {
        header('Location: registration-user.php');
    }
}
?>