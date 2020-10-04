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
                <!-- First Blog Post -->
                <?php 
                    $query = "SELECT * FROM posts WHERE post_status='public' ORDER BY post_id asc";
                    $UsedQuery = $query;

                    if (isset($_POST["submit"])) {
                        $search = $_POST['search'];
                        $Squery = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                        $UsedQuery = $Squery;
                    }

                    // PAGINATION
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = "";
                    }

                    if ($page == "" || $page == 1) {
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * 3) - 3;
                    }

                    $UsedQuery = "SELECT * FROM posts WHERE post_status='public' LIMIT $page_1, 3";

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
                            $post_content = substr( $row["post_content"], 0, 100);

                            echo "
                            <h2>
                                <a href='post.php?id={$post_id}'>{$post_title}</a>
                            </h2>
                            <p class='lead'>
                                by <a href='index.php'>{$post_author}</a>
                            </p>
                            <p><span class='glyphicon glyphicon-time'></span> Posted on {$post_date}</p>
                            <hr>
                            <a href='post.php?id={$post_id}'>
                                <img class='img-responsive' src='./admin/{$post_img}' alt=''>
                            </a>
                            <hr>
                            <p>{$post_content}...</p>
                            <a class='btn btn-primary' href='post.php?id={$post_id}'> Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
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
        <nav>
            <ul class="pagination">
              <li>
                <a href="index.php?page=1" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php 
                $GetNumberOfPostsQuery = "SELECT * FROM posts WHERE post_status='public'";
                $GetNumberOfPostResult = mysqli_query($connection, $GetNumberOfPostsQuery);
                $NumberOfPosts = mysqli_num_rows($GetNumberOfPostResult);
                $NumberOfPages = ceil($NumberOfPosts/3);

                if (isset($_GET['page'])) {
                    for ($i = 1; $i <= $NumberOfPages; $i++) {
                        if ($_GET['page'] == $i) {
                            echo "
                            <li class='active'><a href='index.php?page=$i'>$i</a></li>
                            ";
                        } else {
                            echo "
                            <li><a href='index.php?page=$i'>$i</a></li>
                            ";
                        }
                    }
                } else {
                    for ($i = 1; $i <= $NumberOfPages; $i++) {
                        if ($i == 1) {
                            echo "
                            <li class='active'><a href='index.php?page=$i'>$i</a></li>
                            ";
                        } else {
                            echo "
                            <li><a href='index.php?page=$i'>$i</a></li>
                            ";
                        }
                    }
                }
              ?>
              <li>
                <a href="index.php?page=<?php echo $NumberOfPages; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
        </nav>
        <hr>
<?php 
    include('./includes/footer.php');
?>
