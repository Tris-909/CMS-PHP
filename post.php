<?php 
    include('./includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php 
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $title = $row["cat_title"];
                            echo "<li><a href='#'>{$title}</a></li>";
                        }
                    ?>
                    <li>
                        <a href="admin/index.php">Admin</a>
                    </li>
                    <?php 
                        session_start();        
                        $role = $_SESSION['role'];
                        $CurrentPostID = $_GET['id'];
                        echo "
                            <li>
                            <a href='./admin/index.php?source=edit_post&edit=$CurrentPostID'>Edit this post</a>
                            </li>
                        ";
                    ?>
                </ul>
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo "
                        <ul class='nav navbar-nav navbar-right'>
                           <li class='dropdown'>
                             <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'> {$_SESSION['username']} <span class='caret'></span></a>
                             <ul class='dropdown-menu' role='menu'>
                               <li><a href='#'>Profile</a></li>
                               <li><a href='#'>My Posts</a></li>
                               <li class='divider'></li>
                               <li><a href='./includes/logout.php'>Log Out</a></li>
                             </ul>
                           </li>
                        </ul>
                        ";
                    }
                ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container"> 
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
            <?php 
            include('./includes/db.php');
            if (isset($_GET['id'])) {
                $post_ID = $_GET['id'];
                $Read_Post_Query = "SELECT * FROM posts WHERE post_id=$post_ID";

                $Read_Result = mysqli_query($connection, $Read_Post_Query);
                while ($post = mysqli_fetch_assoc($Read_Result)) {
                    $post_title = $post['post_title'];
                    $post_author = $post['post_author'];
                    $post_date = $post['post_date'];
                    $post_content = $post['post_content'];
                    $post_image = $post['post_image'];    
                    $post_views = $post['post_views'];  
                    
                    echo "
                        <!-- Blog Post -->

                        <!-- Title -->
                        <h1>$post_title</h1>

                        <!-- Author -->
                        <p class='lead'>
                            by <a href='#'>$post_author</a>
                        </p>

                        <hr>

                        <p>$post_views views</p>
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

                    $new_views = $post_views +1;
                    $Update_View_Query = "UPDATE posts SET post_views=$new_views WHERE post_id=$post_ID";
                    mysqli_query($connection, $Update_View_Query);
                }

            }
            ?>
                

                <!-- Blog Comments -->
                <?php 
                    // Create A Comment
                    if (isset($_POST['comment_submit'])) {
                        $comment_post_id = $_GET['id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        $comment_status = 'unapproved';

                        $Add_Comment_Query = "INSERT INTO comments 
                            (comment_post_id, 
                            comment_author, 
                            comment_email, 
                            comment_content, 
                            comment_status, 
                            comment_date) VALUES 
                            ('{$comment_post_id}', 
                            '{$comment_author}', 
                            '{$comment_email}', 
                            '{$comment_content}', 
                            '{$comment_status}',
                            now())";

                        //Increate comment_count by 1 code below :
                        $Get_Current_Count_Query = "SELECT post_id, post_comment_count FROM posts WHERE post_id=$comment_post_id";
                        $GetCountResult = mysqli_query($connection, $Get_Current_Count_Query);
                        checkQueryError($GetCountResult);
                        while ($thisCount = mysqli_fetch_assoc($GetCountResult)) {
                            $postID = $thisCount['post_id'];
                            $currentCount = $thisCount['post_comment_count'];
                            $newCount = $currentCount + 1; 

                            $Update_New_Count_Query = "UPDATE posts SET post_comment_count=$newCount WHERE post_id=$postID";
                            $UpdateResult = mysqli_query($connection, $Update_New_Count_Query);
                            checkQueryError($UpdateResult);
                        } 


                        $AddCommentResult = mysqli_query($connection, $Add_Comment_Query);



                        checkQueryError($AddCommentResult);
                    }


                ?>


                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="POST">
                        <div class="form_group">
                            <label for="comment_author">Comment Author :</label>
                            <input type="text" class="form-control" name="comment_author" required>
                        </div>
                        <br>

                        <div class="form_group">
                            <label for="comment_email">Comment Email :</label>
                            <input type="email" class="form-control" name="comment_email" required>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="comment_content">Comment Content :</label>
                            <textarea class="form-control" rows="3" name="comment_content" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="comment_submit">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php 
                    $Get_Approved_Comments_Query = "SELECT * FROM comments WHERE comment_status LIKE 'approve'";
                    $GetRelatedCommentsResult = mysqli_query($connection, $Get_Approved_Comments_Query);

                    while ($ValidComment = mysqli_fetch_assoc($GetRelatedCommentsResult)) {
                        $comment_author = $ValidComment['comment_author'];
                        $comment_date = $ValidComment['comment_date'];
                        $comment_content = $ValidComment['comment_content'];

                        echo "
                        <div class='media'>
                        <a class='pull-left' href='#'>
                            <img class='media-object' src='http://placehold.it/64x64' alt=''>
                        </a>
                        <div class='media-body'>
                            <h4 class='media-heading'> $comment_author
                                <small>$comment_date</small>
                            </h4>
                                $comment_content
                            </div>
                        </div>
                        ";
                    }
                
                ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
