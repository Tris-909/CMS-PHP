<?php 
    include('../includes/db.php');
?>
<?php 
    session_start();
    include('./includes/header.php');


    if(!isset($_SESSION['username'])) {
        header("Location: ../index.php");
    }
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