<?php  include "includes/header.php"; ?>

    <?php 
        if (isset($_POST['submit'])) {
            $gmail =  escape($_POST['gmail']);
            $subject = escape($_POST['subject']);
            $body = escape($_POST['body']);

            $headers  = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
            $headers .= "From: ". $gmail. "\r\n";
            $headers .= "Reply-To: ". $gmail. "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            $headers .= "X-Priority: 1" . "\r\n";

            $mail = mail('tranminhtri9090@gmail.com', $subject, wordwrap($body, 75), $headers);
            if($mail){
                echo "
                <h3 class='text-center alert alert-danger' role='alert'>Send mail successfully !</h3>
                ";
              } else {
                echo "
                <h3 class='text-center alert alert-danger' role='alert'>Send Mail Failed, please try again</h3>
                ";
            }
        }
    ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-9 col-xs-offset-1">
                <div class="form-wrap">
                <h1>CONTACT</h1>
                    <form role="form" action="contactPage.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="gmail" class="sr-only">gmail</label>
                            <input type="email" name="gmail" id="gmail" class="form-control" placeholder="Enter your gmail" required>
                        </div>
                         <div class="form-group">
                            <label for="subject" class="sr-only">subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject" required>
                        </div>
                         <div class="form-group">
                            <textarea class="form-control" name='body' id='body' cols="30" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>

<?php include "includes/footer.php";?>
