<?php 
    include('./includes/db.php');
?>
<?php 
    include('./includes/header.php');
?>
<?php 
    include('./includes/navigation.php');
?>

<?php 
    if (isset($_POST['like'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //! Get the likes from this post
        $Select_post_query = "SELECT * FROM posts WHERE post_id = $post_id";
        $PostResult = mysqli_query($connection, $Select_post_query);
        checkQueryError($PostResult);

        while ($post = mysqli_fetch_assoc($PostResult)) {
            $currentlike = $post['likes'];
            $newLikeCount = $currentlike + 1;

            //! Update new likes into this post
            $Update_Like_Count_Query = "UPDATE posts SET likes = $newLikeCount WHERE post_id = $post_id";
            $UpdateLikeResult = mysqli_query($connection, $Update_Like_Count_Query);
            checkQueryError($UpdateLikeResult);

            //! Create a doc in likes database
            $create_docs_for_likes_query = "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)";
            $InsertLikesResult = mysqli_query($connection, $create_docs_for_likes_query);
            checkQueryError($InsertLikesResult);

            header("Location: ./post.php?id=$post_id");
        }
    }

    if (isset($_POST['unlike'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        $Select_post_query = "SELECT * FROM posts WHERE post_id = $post_id";
        $PostResult = mysqli_query($connection, $Select_post_query);
        checkQueryError($PostResult);

        while ($post = mysqli_fetch_assoc($PostResult)) {
            $currentlike = $post['likes'];
            $newLikeCount = $currentlike -1;

            $Update_Like_Count_Query = "UPDATE posts SET likes = $newLikeCount WHERE post_id = $post_id";
            $UpdateLikeResult = mysqli_query($connection, $Update_Like_Count_Query);
            checkQueryError($UpdateLikeResult);

            $remove_docs_for_likes_query = "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id";
            $InsertLikesResult = mysqli_query($connection, $remove_docs_for_likes_query);
            checkQueryError($InsertLikesResult);

            header("Location: ./post.php?id=$post_id");
        }
    }
?>
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
                    $post_likes = $post['likes'];

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
                        ";
                    
                    if (isset($_SESSION['userID'])) {
                        $post_id = $_GET['id'];
                        $user_id = $_SESSION['userID'];

                        $Query_Isliked = "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id ";
                        $Check_IsLiked_Result = mysqli_query($connection, $Query_Isliked);
                        checkQueryError($Check_IsLiked_Result);
                        $Count = mysqli_num_rows($Check_IsLiked_Result);

                        if ($Count != 0) {
                            echo "
                            <div>
                                <p class='pull-right'><a class='unlike' href='post.php?id=$post_id'><span class='glyphicon glyphicon-thumbs-down'></span> UnLike</a></p>
                                <p class='pull-left'>Like : $post_likes</p>
                                </div>
                            <hr>
                            ";
                        } else {
                            echo "
                            <div>
                                <p class='pull-right'><a class='likes' href='post.php?id=$post_id'><span class='glyphicon glyphicon-thumbs-up'></span> Like</a></p>
                                <p class='pull-left'>Like : $post_likes</p>
                                </div>
                            <hr>
                            ";
                        }



                    } else {
                        echo "
                            <div class='row'>
                            <p class='pull-right'>Please <a href='login.php'> sign in </a> to like this post</p>
                            <p class='pull-left'>Like : $post_likes</p>
                            </div>
                            <hr>
                        ";
                    }

                    echo "
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
                    if (isset($_POST['comment_submit']) && isset($_SESSION['username'])) {
                        $comment_post_id = $_GET['id'];
                        $comment_author = $_SESSION['username'];
                        $comment_email = $_SESSION['email'];
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

                        while ($thisCount = mysqli_fetch_assoc($GetCountResult)) {
                            $postID = $thisCount['post_id'];
                            $currentCount = $thisCount['post_comment_count'];
                            $newCount = $currentCount + 1; 

                            $Update_New_Count_Query = "UPDATE posts SET post_comment_count=$newCount WHERE post_id=$postID";
                            $UpdateResult = mysqli_query($connection, $Update_New_Count_Query);
                        } 


                        $AddCommentResult = mysqli_query($connection, $Add_Comment_Query);
                    }


                ?>


                <!-- Comments Form -->
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo "
                        <div class='well'>
                        <h4>Leave a Comment:</h4>
                        <form role='form' method='POST'>
                            <div class='form-group'>
                                <label for='comment_content'>Comment Content :</label>
                                <textarea class='form-control' rows='3' name='comment_content' required></textarea>
                            </div>
                            <button type='submit' class='btn btn-primary' name='comment_submit'>Submit</button>
                        </form>
                        </div>
                        ";
                    } else {
                        echo "
                        <div class='jumbotron'>
                            <h4 style='text-align: center;'> Please sign in to comment on this post </h4>
                        </div>
                        ";
                    }
                ?>



                <!-- Posted Comments -->

                <!-- Comment -->
                <?php 
                    $post_ID = $_GET['id'];
                    $Get_Approved_Comments_Query = "SELECT * FROM comments WHERE comment_status LIKE 'approve' AND comment_post_id='$post_ID'";
                    $GetRelatedCommentsResult = mysqli_query($connection, $Get_Approved_Comments_Query);

                    if (!$GetRelatedCommentsResult) {
                        echo "QUERY FAILED " . mysqli_error($connection);
                    }

                    while ($ValidComment = mysqli_fetch_assoc($GetRelatedCommentsResult)) {
                        $comment_author = $ValidComment['comment_author'];
                        $comment_date = $ValidComment['comment_date'];
                        $comment_content = $ValidComment['comment_content'];

                        echo "
                        <hr>
                        <div class='media'>
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

            <?php include('./includes/sidebar.php'); ?>

        </div>
        <!-- /.row -->

        <hr>

<?php 
    include('./includes/footer.php');
?>

<script>
    $(document).ready(function(){
        //! trigger like function
        $('.likes').click(function(){
            var post_id = <?php echo $_GET['id']; ?>;
            var user_id = <?php echo $_SESSION['userID']; ?>;
            
            $.ajax({
                url: "/post.php?id=<?php echo $_GET['id']; ?>",
                type: 'post',
                data: {
                    'like': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });

        //! Trigger unlike function
        $('.unlike').click(function(){
            var post_id = <?php echo $_GET['id']; ?>;
            var user_id = <?php echo $_SESSION['userID']; ?>;

            $.ajax({
                url: "/post.php?id=<?php echo $_GET['id']; ?>",
                type: 'post',
                data: {
                    'unlike': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });
    });


</script>