<?php include "includes/db.php";  ?>
<?php include "includes/header.php"; ?>
<?php   
    if (isset($_GET['email']) && isset($_GET['token'])) {
        $email = escape($_GET['email']);
        $token = escape($_GET['token']);

        $Get_Token_From_Databases = "SELECT * FROM users WHERE token='$token'";
        $GetTokenResult = mysqli_query($connection, $Get_Token_From_Databases);
        checkQueryError($GetTokenResult);
        $Count = mysqli_num_rows($GetTokenResult);

        if ($Count == 0) {
            header("Location: index.php");
        } else {
            
            if (isset($_POST['recover_password']) && isset($_POST['ConfirmPassword'])) {
                $new_password = escape($_POST['password']);
                $confirm_password = escape($_POST['ConfirmPassword']);
        
                if ($new_password != $confirm_password) {
                    $failed_message = "Your Password and confirm password are not matched";
                } else {
                    $password = password_hash($new_password, PASSWORD_BCRYPT, array('cost' => 12));
        
                    $Reset_Password_Query = "UPDATE users SET user_password = '$password', token='' WHERE user_email='$email' AND token='$token' ";
                    $ResetResult = mysqli_query($connection, $Reset_Password_Query);
                    checkQueryError($ResetResult);
        
                    $success_message = "Your password has been reset, <a href='login.php'>click here</a> to log in ";
                }
            }

        }

    }

?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">RESET YOUR PASSWORD</h2>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <label for="password">New Password :</label>
                                            <input 
                                                autocomplete="on"
                                                value="<?php echo isset($new_password) ? $new_password : '' ?>" 
                                                id="password" 
                                                name="password" 
                                                placeholder="password" 
                                                class="form-control"  
                                                type="password">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="ConfirmPassword">Confirm Password :</label>
                                            <input
                                                autocomplete="on"
                                                value="<?php echo isset($confirm_password) ? $confirm_password : '' ?>" 
                                                id="ConfirmPassword" 
                                                name="ConfirmPassword" 
                                                placeholder="Re-type your new password" 
                                                class="form-control"  
                                                type="password">
                                        </div>

                                        <?php 
                                            if (isset($failed_message)) {
                                                echo "
                                                <h3 class='text-center alert alert-danger' role='alert'>
                                                    $failed_message
                                                </h3>
                                                ";
                                            }

                                            if (isset($success_message)) {
                                                echo "
                                                <h3 class='text-center alert alert-success' role='alert'>
                                                    $success_message
                                                </h3>
                                                ";
                                            }
                                        ?>

                                        <div class="form-group">
                                            <input name="recover_password" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /.container -->

