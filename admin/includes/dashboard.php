                <!-- /.row -->
                
                <div class="row">
                <h1 class="page-header"> 
                    Welcome back 
                    <small> <?php echo $_SESSION['firstname']; echo " "; echo $_SESSION['lastname']; ?> </small>
                </h1>   
    <div class="col-lg-3 col-md-6">
        <?php 
            $GetPostsQuery = "SELECT * FROM posts";
            $GetPostsResult = mysqli_query($connection, $GetPostsQuery);
            checkQueryError($GetPostsResult);
            $numberOfPosts = mysqli_num_rows($GetPostsResult);
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $numberOfPosts; ?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="./index.php?source=view_all_post">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <?php 
            $GetCommentsQuery = "SELECT * FROM comments";
            $GetCommentsResult = mysqli_query($connection, $GetCommentsQuery);
            checkQueryError($GetCommentsResult);
            $CommentsCount = mysqli_num_rows($GetCommentsResult);
        ?>
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $CommentsCount; ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="./index.php?source=view_comments">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <?php 
            $GetUsersQuery = "SELECT * FROM users";
            $GetUsersResult = mysqli_query($connection, $GetUsersQuery);
            checkQueryError($GetUsersResult);
            $UserCounts = mysqli_num_rows($GetUsersResult);
        ?>
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $UserCounts; ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="./index.php?source=view_users">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <?php 
            $GetCategoriesQuery = "SELECT * FROM categories";
            $GetCategoriesResult = mysqli_query($connection, $GetCategoriesQuery);
            checkQueryError($GetCategoriesResult);
            $CategoriesCount = mysqli_num_rows($GetCategoriesResult);
        ?>
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class='huge'><?php echo $CategoriesCount; ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="./index.php?source=categories">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<?php 
    //Get draft and public posts 
    $Get_Draft_Posts_Query = "SELECT * FROM posts WHERE post_status='draft'";
    $GetDraftPostsResult = mysqli_query($connection, $Get_Draft_Posts_Query);
    checkQueryError($GetDraftPostsResult);
    $NumberOfDraftPosts = mysqli_num_rows($GetDraftPostsResult);

    $Get_Public_Posts_Query = "SELECT * FROM posts WHERE post_status='public'";
    $GetPublicPostsResult = mysqli_query($connection, $Get_Public_Posts_Query);
    checkQueryError($GetPublicPostsResult);
    $NumberOfPublicPosts = mysqli_num_rows($GetPublicPostsResult);
?>


<div class="row">
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawAnotherChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Overall', 'Posts', 'Categories', 'Users', 'Comments'],
          ['2020', <?php echo $numberOfPosts; ?>, <?php echo $CategoriesCount; ?>, <?php echo $UserCounts; ?>, <?php echo $CommentsCount; ?>],
        ]);

        var options = {
          chart: {
            title: 'CMS Summary',
            subtitle: '2020',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

      function drawAnotherChart() {
        var postsData = google.visualization.arrayToDataTable([
            ['Draft/Public Posts', 'Draft', 'Public', 'Total Posts'],
            ['2020', <?php echo $NumberOfDraftPosts; ?>, <?php echo  $NumberOfPublicPosts; ?>, <?php echo $numberOfPosts; ?>]
        ]);

        var PostsOptions = {
            chart: {
                title: 'Posts Summary',
                subtitle: '2020'
            }
        }

        var postsChart = new google.charts.Bar(document.getElementById('new_columnchart_material'));
        postsChart.draw(postsData, google.charts.Bar.convertOptions(PostsOptions));
      }
    </script>
    <br>
    <div id="columnchart_material" style="width: 80%; height: 400px;  margin: 0 auto;"></div>
    <br>
    <div id="new_columnchart_material" style="width: 80%; height: 400px;  margin: 0 auto;"></div>
</div>