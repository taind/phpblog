<?php require('includes/config.php'); ?>
<html>
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header class="container">
        <div class="row">
            <img class="col-sm-2" src="images/logoblog.png">
            <nav class="col-sm-10 text-right">
                <p>About</p>
                <p>Contact</p>
            </nav>
        </div>
    </header>
    <hr>
    <section class="container">
        <div class="row">
            <figure class="col-sm-9">
            <?php
            try {

                $stmt = $db->query('SELECT postID, postTitle,postSlug, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
                while($row = $stmt->fetch()){

                    echo '<div>';
                    echo '<h1><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>'; // title chứa link đến post
                    echo '<p>Posted on '.date('jS M Y H:i A', strtotime($row['postDate'])).' in '; // chen category sau date post
                            $stmt2 = $db->prepare('Select catTitle,catSlug from blog_cats,blog_post_cats where blog_cats.catID=blog_post_cats.catID and blog_post_cats.postID=?');
                            $stmt2->execute(array($row['postID']));
                            $catrow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            $link = array();
                            foreach($catrow as $zcatrow){
                                $link[] = "<a href='c-".$zcatrow['catSlug']."'>".$zcatrow['catTitle']."</a>";
                            }
                            echo implode(",", $link);
                    echo "</p>";
                    echo '<p>'.$row['postDesc'].'</p>';
                    echo '<p><a href="'.$row['postSlug'].'">Read More</a></p>';
                    echo '</div>';

                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            ?>
            </figure>
            <figure class="col-sm-3">
                <?php require ("sidebar.php"); ?>
            </figure>
        </div>
    </section>
</body>
</html>