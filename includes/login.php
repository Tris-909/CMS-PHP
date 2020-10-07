<?php include "./db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php session_start(); ?>
<?php 

    if(isset($_POST['login'])) {
        $Account = $_POST['account'];
        $Password = $_POST['password'];

        $Account = mysqli_real_escape_string($connection, $Account);
        $Password = mysqli_real_escape_string($connection, $Password);

        LogInUser($Account, $Password);
    }
?>