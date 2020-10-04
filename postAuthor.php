<?php 
    include('./includes/header.php');
?>

    <!-- Navigation -->
    <?php 
        include('./includes/navigation.php');
    ?>

    <!-- Page Content -->
    <div class="container"> 
        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
            <div class="page-header">
                <h1>Here is all your posts <small><?php if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                }  ?></small></h1>
            </div>
            <?php 
            include('./includes/db.php');
            if (isset($_SESSION['username'])) {
                $Author = $_SESSION['username'];
                $Read_Post_Query = "SELECT * FROM posts WHERE post_author='$Author' ";

                $Read_Result = mysqli_query($connection, $Read_Post_Query);
                while ($post = mysqli_fetch_assoc($Read_Result)) {
                    $post_id = $post['post_id'];
                    $post_title = $post['post_title'];
                    $post_author = $post['post_author'];
                    $post_date = $post['post_date'];
                    $post_content = $post['post_content'];
                    $post_image = $post['post_image'];    

                    
                    echo "
                        <!-- Blog Post -->
                        <div style='border: 2px solid black; padding: 5%;' >
                            <!-- Title -->
                            <h2><a href='post.php?id=$post_id'>$post_title</a> <small><span class='glyphicon glyphicon-time'></span> Posted on $post_date</small></h2>                            
                            <hr>

                            <!-- Preview Image -->
                            <img class='img-responsive' src='./admin/$post_image' alt=''>
                        </div>
                        <br>
                    ";
                }

            }
            ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php 
                include('./includes/sidebar.php');
            ?>

        </div>
        <!-- /.row -->

        <hr>
<?php 
    include('./includes/footer.php');
?>
