<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="row">
            <div class="col-md-2">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        Menu <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.php">Team Vizion</a>
                </div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="col-md-10">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#">Hello, <?php echo $_SESSION['username']; ?></a>
                        </li>
                        <li>
                            <a href="index.php">Post</a>
                        </li>
                        <li>
                            <a href="categories.php">Category</a>
                        </li>
                        <li>
                            <a href="users.php">User</a>
                        </li>
                        <li>
                            <a href="../index.php" target="_blank">View website</a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<div class='clear'></div>
<hr />
<hr />