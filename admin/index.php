<?php 
    include('../includes/db.php');
?>
<?php 
    session_start();
    include('./includes/header.php');


    if(!isset($_SESSION['username'])) {
        header("Location: ../index.php");
    }

    // Login Successfully create a new id upon session and save it to databases
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 10;
    $time_out = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session='$session' ";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);

    // $count is number of users online at the moment, display this to see how many users is online at the moment

    if ($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('$session','$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time='$time' WHERE session='$session'");
    }

    $users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
    $count_users = mysqli_num_rows($users_online);

?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php 
            include('./includes/navigation.php');
        ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php 
                            if(isset($_GET["source"])) {
                                $source =  $_GET["source"];
                            } else {
                                $source = ''; 
                            } 

                            switch($source) {
                                case 'view_all_post':
                                    include './includes/view_all_posts.php';
                                    break;
                                case 'add_post':
                                    include './includes/add_post.php';
                                    break;
                                case 'edit_post':
                                    include './includes/edit_post.php';
                                    break;
                                case 'view_post_comments':
                                    include './includes/view_post_comments.php';
                                    break;
                                case 'categories':
                                    include './categories.php';
                                    break;
                                case 'view_comments':
                                    include './includes/comments.php';
                                    break;
                                case 'add_comment':
                                    include './includes/add_comment.php';
                                    break;
                                case 'view_users':
                                    include './includes/users.php';
                                    break;
                                case 'add_users':
                                    include './includes/add_user.php';
                                    break;
                                case 'edit_users':
                                    include './includes/edit_users.php';
                                    break;
                                case 'profile':
                                    include './includes/profile.php';
                                    break;
                                default: 
                                    include "./includes/dashboard.php";
                                    break;
                            }
                        ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<?php 
    include('./includes/footer.php');
?>