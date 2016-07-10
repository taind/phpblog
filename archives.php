<html>
<head>
    <meta charset="utf-8">
    <title>Blog Archives </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme CSS -->
    <link href="css/clean-blog.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="index.php">Team Vizion</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="about.html">About</a>
                </li>
                <li>
                    <a href="contact.html">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('img/home-bg2.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1>Team Vizion Blog</h1>
                    <hr class="small">
                    <span class="subheading">IS207.G21 FINAL PROJECT</span>
                    <span class="subheading">Personal Blog</span>

                </div>
            </div>
        </div>
    </div>
</header>
<body>
<article class="select-container">
<section class="container">
    <div class="row">
        <figure class="col-sm-9">
<?php
require_once ("includes/config.php");
$year = $_GET['year'];
$month = $_GET['month'];
$from = date('Y-m-01 00:00:00',strtotime("$year-$month"));
$to = date('Y-m-31 23:59:59',strtotime("$year-$month"));
try{
    $pages = new Paginator('5','p');
    $stmt = $db->prepare("select postID from blog_posts where postDate>=? and postDate <= ? order by postDate DESC");
    $stmt->execute(array($from,$to));
    $pages->set_total($stmt->rowCount());
    $stmt = $db->prepare("select postID,postDesc,postTitle,postSlug,postDate,postAuthor from blog_posts where postDate>=? and postDate <= ? order by postDate DESC ".$pages->get_limit());
    $stmt->execute(array($from,$to));
    while($row = $stmt->fetch()){
        echo '<div class="post-preview">';
        echo '<h2 class="post-title"><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></h2>'; // title chứa link đến post
        echo '<a><h3 class="post-subtitle">'.$row['postDesc'].'</h3></a>';
        echo '<p class="post-meta">Posted on <a> '.date('jS M Y H:i A', strtotime($row['postDate'])).'</a> in <a><i class="fa fa-tags"></i> '; // chen category sau date post
        try{
            $stmt2 = $db->prepare("select blog_cats.catTitle, blog_cats.catSlug from blog_post_cats,blog_cats where blog_cats.catID=blog_post_cats.catID and blog_post_cats.postID=?");
            $stmt2->execute(array($row['postID']));
            $row_cat = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $links = array();
            foreach($row_cat as $zrow_cat){
                $links[] = "<a href='c-".$zrow_cat['catSlug']."'>".$zrow_cat['catTitle']."</a>";
            }
            echo implode($links);
            echo "</a> by <a><i class='fa fa-user'></i> ".$row['postAuthor'];
            echo "</a></p>";
            echo '</div>';
            echo "<hr>";
        }catch (PDOException $eee){
            echo $eee->getMessage();
        }

    }
}catch(PDOException $e){
    echo $e->getMessage();
}
echo $pages->page_links("a-$month-$year&");
?>
        </figure>
        <figure class="col-sm-3">
            <?php require ("sidebar.php"); ?>
        </figure>
     </div>
</section>
</article>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="list-inline text-center">
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                </ul>
                <p class="copyright text-muted">Copyright &copy; Team Vizion</p>
                <p class="text-center"><?php include "includes/hitcounter.php"; ?></p>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.js"></script>
<script src="js/contact_me.js"></script>

<!-- Theme JavaScript -->
<script src="js/clean-blog.min.js"></script>
</body>
</html>
