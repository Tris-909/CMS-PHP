<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php     
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    if (isset($_GET['userID'])) {

        $userID = $_GET['userID'];

        $Get_Info_Query = "SELECT * FROM users WHERE user_id=$userID";
        $GetInfoResult = mysqli_query($connection, $Get_Info_Query);
        checkQueryError($GetInfoResult);
        
        while ($User = mysqli_fetch_assoc($GetInfoResult)) {
            $user_name = $User['user_account'];
            $user_firstname = $User['user_firstname'];
            $user_lastname = $User['user_lastname'];
            $user_email = $User['user_email'];
            $user_role = $User['user_role'];
        }
    }

    if (isset($_POST['update_profile'])) {
        $userID = $_GET['userID'];

        $new_username = $_POST['user_account'];
        $new_firstname = $_POST['user_firstname'];
        $new_lastname = $_POST['user_lastname'];
        $new_email = $_POST['user_email'];

        $UpdateQuery = "UPDATE users SET user_account='$new_username', user_firstname='$new_firstname', user_lastname='$new_lastname', user_email='$new_email' WHERE user_id=$userID";
        $UpdateResult = mysqli_query($connection, $UpdateQuery);
        checkQueryError($UpdateResult);

        header("Location: profile.php?userID=$userID");
    }
?>

<!-- Page Content -->
<div class="container">
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-9 col-xs-offset-1">
                <div class="form-wrap">
                <div class="page-header">
                    <h1>Your Profile : </h1>
                </div>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form_group">
                        <label for="title">Account :</label>
                        <input type="text" class="form-control" name="user_account" value="<?php echo $user_name; ?>">
                    </div>
                    <br>
                                         
                    <div class="form_group">
                        <label>Change Your Password : </label>
                        <a href='./forgot_password.php?forgot=<?php echo uniqid(true); ?>'> Click here </a>
                    </div>
                    <br>
                        
                    <div class="form_group">
                        <label for="title">First Name : </label>
                        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
                    </div>
                    <br>
                        
                    <div class="form_group">
                        <label for="title">Last Name : </label>
                        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
                    </div>
                    <br>
                        
                    <div class="form_group">
                        <label for="title">Email : </label>
                        <input type="text" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
                    </div>
                    <br>
                        
                    <div class="form_group">
                        <input class="btn btn-primary" type="submit" name="update_profile" value="Update">
                    </div>
                </form>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>

<?php include "includes/footer.php";?>

