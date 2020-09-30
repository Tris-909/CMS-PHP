<?php 
    include('./includes/db.php');
    include('./includes/header.php');
?>
    <!-- Navigation -->
    <?php 
        include('./includes/navigation.php');
    ?>

    <!-- Page Content -->   
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <?php 
                    $query = "SELECT * FROM posts";
                    $UsedQuery = $query;

                    if (isset($_POST["submit"])) {
                        $search = $_POST['search'];
                        $Squery = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                        $UsedQuery = $Squery;
                    }

                    $postRead = mysqli_query($connection, $UsedQuery);
                    $count = mysqli_num_rows($postRead);
                    if ($count == 0) {
                        echo "<h1>Can't Find Posts</h1>";
                    } else {
                        while ($row = mysqli_fetch_assoc($postRead)) {
                            $post_id = $row["post_id"];
                            $post_title = $row["post_title"];
                            $post_author = $row["post_author"];
                            $post_date = $row["post_date"];
                            $post_img = $row["post_image"];
                            $post_content = $row["post_content"];

                            echo "
                            <h2>
                                <a href='post.php?id={$post_id}'>{$post_title}</a>
                            </h2>
                            <p class='lead'>
                                by <a href='index.php'>{$post_author}</a>
                            </p>
                            <p><span class='glyphicon glyphicon-time'></span> Posted on {$post_date}</p>
                            <hr>
                            <img class='img-responsive' src='./admin/{$post_img}' alt=''>
                            <hr>
                            <p>{$post_content}</p>
                            <a class='btn btn-primary' href='#'> Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
                            <hr> ";
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
