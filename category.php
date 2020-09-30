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
                <?php 
                if (isset($_GET['category_id']))
                    $category_id = $_GET['category_id'];     
                    $get_related_category = "SELECT * FROM categories WHERE cat_id=$category_id";

                    $getTitleResult = mysqli_query($connection, $get_related_category);

                    while($row = mysqli_fetch_assoc($getTitleResult)) {
                        $category_title = $row['cat_title'];
                        $category_id = $row['cat_id'];

                        echo "
                            <h1 class='page-header'>
                                CATEGORY : $category_title
                                <small>Related Posts</small>
                            </h1>
                        ";

                        $Find_Related_Posts_Query = "SELECT * FROM posts WHERE post_category_id=$category_id";
                        $GetRelatedPostResult = mysqli_query($connection, $Find_Related_Posts_Query);

                        $count = mysqli_num_rows($GetRelatedPostResult);
                        if ($count == 0) {
                            echo "<h1>Can't Find Posts related to $category_title</h1>";
                        } else {
                            while ($row = mysqli_fetch_assoc($GetRelatedPostResult)) {
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
