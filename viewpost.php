<?php
require ('includes/config.php');
$stmt = $db->prepare('Select postID,postDesc,postTitle,postDate,postCont,postAuthor,postView from blog_posts where postSlug= ?');
$stmt->execute(array($_GET['id'])); // get id bên index truyen qua va quang vao statement o tren
$row=$stmt->fetch();
if($row['postID'] == ''){
    header('Location: ./');
    exit;
}

$session_name = "view".$row['postID'];
$checkview = $_SESSION[$session_name];
if(empty($checkview)){ // nếu check view rỗng,tức là lần đầu xem trong session,
    $_SESSION[$session_name]=1; // set 1 tức là đã xem
    $stmt = $db->query('UPDATE blog_posts SET postView=postView+1 WHERE postID='.$row['postID']); //tăng 1 lượt view
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $row['postTitle'];?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Clean Blog</title>
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
<body>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '166170170465990',
            xfbml      : true,
            version    : 'v2.6'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Navigation -->
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
<header class="intro-header" style="background-image: url('img/home-bg3.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?php echo $row['postTitle']; ?></h1>
                    <h2 class="subheading"><?php echo $row['postDesc']; ?></h2>
                    <span class="meta">Posted by <a href="#"><i class="fa fa-user"></i> <?php echo $row['postAuthor']; ?></a> on <?php echo date('jS M Y H:i A', strtotime($row['postDate'])); ?> in <i class="fa fa-tags"></i>
                    <?php
                    $stmt2 = $db->prepare('Select catTitle,catSlug from blog_cats,blog_post_cats where blog_cats.catID=blog_post_cats.catID and blog_post_cats.postID=?');
                    $stmt2->execute(array($row['postID']));
                    $catrow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    $link = array();
                    foreach($catrow as $zcatrow){
                        $link[] = "<a href='c-".$zcatrow['catSlug']."'>".$zcatrow['catTitle']."</a>";
                    }
                    echo implode(", ", $link);
                    ?>

                    </span>
                </div>
            </div>
        </div>
    </div>
</header>
<article class="select-container">
    <section class="container">
        <div class="row">
            <figure class="col-sm-9">
                <div class="fb-like" data-href="http://20namsau.com/phpblog/<?php echo $_GET['id']; ?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
                <?php
                echo '<div>';
                echo 'Lượt xem: '.$row['postView'];
                echo '<p>'.$row['postCont'].'</p>';
                echo '</div>';
                ?>
                <hr>
                <span class="meta">
                    <p>Related post</p>
                    <?php
                    $stmt_re = $db->prepare('SELECT postID,postSlug,postTitle FROM blog_posts where postID < ? ORDER BY postID DESC limit 0,3');
                    $stmt_re->execute(array($row['postID']));
                    echo '<ul>';
                    while($row = $stmt_re->fetch()){
                        echo '<li><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></li>';
                    }
                    echo '</ul>';
                    ?>
                </span>
                <div style="text-align: center;">
                    <div class="fb-comments" data-href="http://20namsau.com/phpblog/<?php echo $_GET['id']; ?>" data-width="700" data-numposts="5"></div>
                </div>
            </figure>
            <figure class="col-sm-3">
                <?php require ("sidebar.php"); ?>
            </figure>
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


