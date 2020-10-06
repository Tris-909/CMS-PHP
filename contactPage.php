<?php  include "includes/header.php"; ?>

    <?php 
        if (isset($_POST['submit'])) {
            $gmail =  escape($_POST['gmail']);
            $subject = escape($_POST['subject']);
            $body = escape($_POST['body']);
            $headers = "FROM: $gmail" . "\r\n";


            $mail = mail("tranminhtri9090@gmail.com", $subject, wordwrap($body, 75), $headers);
            if($mail){
                echo "Thank you for using our mail form";
              } else {
                echo "Mail sending failed."; 
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
