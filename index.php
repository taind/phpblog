<?php require('includes/config.php'); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
<h1>Blog</h1>
<hr>
<?php
try {

    $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
    while($row = $stmt->fetch()){

        echo '<div>';
        echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
        echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in '; // chen category sau date post
            $stmt2 = $db->prepare('SELECT catTitle,catSlug from blog_cats,blog_post_cats where blog_cats.catID=blog_post_cats.catID and blog_post_cats.postID= ?');
            $stmt2->execute(array($row['postID']));
            $catrow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $links=array();
            foreach ($catrow as $zcatrow){
                $links[]='<a href="c-'.$zcatrow['catSlug'].'">'.$zcatrow['catTitle'].'</a>';
            }
            echo implode(", ", $links);
            echo '</p>';
        echo '<p>'.$row['postDesc'].'</p>';
        echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';
        echo '</div>';

    }

} catch(PDOException $e) {
    echo $e->getMessage();
}
?>
</body>
</html>