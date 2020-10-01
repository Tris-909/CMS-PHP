<?php 
    include('./includes/header.php');
    include('./functions.php');
    include('../includes/db.php');
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
                                case 'add_post':
                                    include './includes/add_post.php';
                                    break;
                                case 'edit_post':
                                    include './includes/edit_post.php';
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
                                default: 
                                    include "./includes/view_all_posts.php";
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