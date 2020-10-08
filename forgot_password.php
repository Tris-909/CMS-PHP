<?php 
    //! Code from PHPMailer Github
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    include "includes/db.php"; 
?>

<?php include "includes/header.php"; ?>

<?php 
    require './vendor/autoload.php';
    require './classes/config.php';

    if (isset($_SESSION['username']) || (!isset($_GET['forgot'])) ) {
        header("Location: ./index.php");
    }

    if (isset($_POST['recover-submit'])) {
        $email = escape($_POST['email']);

        $length = 50;

        $token = bin2hex(openssl_random_pseudo_bytes($length));

        if (Is_Email_Existed($email)) {
            $Add_Token_Query = "UPDATE users SET token='$token' WHERE user_email='$email' ";
            mysqli_query($connection, $Add_Token_Query);
            
            //! All of the code below in this red comment is from PHPMAILER Github Docs
            $mail = new PHPMailer(true);
            
            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = Config::SMTP_HOST;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = Config::SMTP_USER;                     // SMTP username
                $mail->Password   = Config::SMTP_PASSWORD;                 // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = Config::SMTP_PORT;                     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->CharSet='UTF-8'; // Allow text to display in other languages 

                //Recipients
                $mail->setFrom('tranminhtri9090@gmail.com', 'TrisTran');
                $mail->addAddress($email);     // Add a recipient
            
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Reset your password in CMS';
                $mail->Body    = '<p>Please 
                <a href="https://shrouded-springs-90128.herokuapp.com/reset.php?email='.$email.'&token='.$token.' "> click here </a>
                to reset your password</p>';
                
                // http://localhost:8888/ link for development mode
                // https://shrouded-springs-90128.herokuapp.com/ link for production mode

                $mail->send();
                $success = true;

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            //! End of PHPMAILER CODE
            
        }
    }


?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <?php 
                                            if (isset($success)) {
                                                if ($success === true) {
                                                    echo "
                                                    <h3 class='text-center alert alert-success' role='alert'>
                                                        Email has been sent successfully, please check your email
                                                    </h3>
                                                    ";
                                                }
                                            }
                                        ?>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
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


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

