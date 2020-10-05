<?php include "./db.php"; ?>
<?php session_start(); ?>
<?php 
    include('./db.php');

    if(isset($_POST['login'])) {
        $Account = $_POST['account'];
        $Password = $_POST['password'];

        $Account = mysqli_real_escape_string($connection, $Account);
        $Password = mysqli_real_escape_string($connection, $Password);

        $GetHashedPassword = "SELECT * FROM users WHERE user_account='$Account'";
        $GetHashedPasswordResult = mysqli_query($connection, $GetHashedPassword);

        while ($password = mysqli_fetch_assoc($GetHashedPasswordResult)) {
            $id = $password['user_id'];
            $db_account = $password['user_account'];
            $HashedPassword = $password['user_password'];
            $firstname = $password['user_firstname'];
            $lastname = $password['user_lastname'];
            $email = $password['user_email'];
            $role = $password['user_role'];
        }

        if (password_verify($Password, $HashedPassword)) {
            $_SESSION['userID'] =  $id;
            $_SESSION['username'] = $db_account; 
            $_SESSION['password'] = $HashedPassword;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            header("Location: ../admin/index.php");

        } else {
            header("Location: ../index.php");
        }
    }
?>