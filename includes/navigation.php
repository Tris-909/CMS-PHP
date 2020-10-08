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
                <a class="navbar-brand" href="../index">CMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php 
                        echo "
                            <li>
                                <a href='../contactPage'> Contact </a>
                            </li>
                        ";
                    ?>
                    <?php 
                        if (isAdmin()) {
                            echo "
                            <li>
                                <a href='admin/index.php'> ADMIN </a>
                            </li>
                            ";
                        }
                    ?>
                    <?php 
                        if (!isLogIn()) {
                            echo "
                            <li>
                                <a href='./registration'>Sign Up</a>
                            </li>
                            <li>
                                <a href='./login.php'>Login</a>
                            </li>
                            ";
                        }
                    ?>

                </ul>
                <?php 
                if (isLogIn()) {
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