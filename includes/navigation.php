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
                <a class="navbar-brand" href="../index.php">CMS</a>
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
                    <?php 

                        if (isset($_SESSION['username'])) {
                            if ($_SESSION['role'] == 'admin') {
                                echo "
                                <li>
                                    <a href='admin/index.php'>Admin</a>
                                </li>
                                ";
                            }
                        }
                    ?>
                    <?php 
                        if (empty($_SESSION['username'])) {
                            echo "
                            <li>
                                <a href='./registration.php'>Sign Up</a>
                            </li>
                            ";
                        }
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
                               <li><a href='postAuthor.php'>My Posts</a></li>
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