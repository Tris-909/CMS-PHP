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
                    $post_title = $post['post_title'];
                    $post_author = $post['post_author'];
                    $post_date = $post['post_date'];
                    $post_content = $post['post_content'];
                    $post_image = $post['post_image'];    

                    
                    echo "
                        <!-- Blog Post -->

                        <!-- Title -->
                        <h2>$post_title</h2>

                        <!-- Author -->
                        <p class='lead'>
                            by <a href='#'>$post_author</a>
                        </p>

                        <hr>

                        <!-- Date/Time -->
                        <p><span class='glyphicon glyphicon-time'></span> Posted on $post_date</p>
                        <hr>

                        <!-- Preview Image -->
                        <img class='img-responsive' src='./admin/$post_image' alt=''>

                        <hr>

                        <!-- Post Content -->
                        <p class='lead'> $post_content </p>
                        <hr>
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
