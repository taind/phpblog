<?php require ('includes/config.php');
$stmt = $db->prepare('Select catID, catTitle from blog_cats where catSlug=?');
$stmt->execute(array($_GET['id'])); //id được truyền vào bằng rule htacess
$row_cat = $stmt->fetch();
if($row_cat['catID']==''){
    header('Location: ./');
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog-<?php echo $row_cat['catTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

<h1>Blog</h1>
<hr>
<p><a href="./">Blog Index</a></p>
<h3>Post in <?php echo $row_cat['catTitle'];?></h3>
<?php
try {

    $stmt = $db->prepare('SELECT blog_posts.postID, blog_posts.postTitle,blog_posts.postSlug, blog_posts.postDesc, blog_posts.postDate 
                        FROM blog_posts, blog_post_cats
                        WHERE blog_posts.postID = blog_post_cats.postID
                        AND blog_post_cats.catID = ?
                        ORDER BY postID DESC');
    $stmt->execute(array($row_cat['catID']));
    while($row = $stmt->fetch()){
        echo '<div>';
        echo '<h1><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>'; // title chứa link đến post
        echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in '; // chen category sau date post
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

</div>


</body>
</html>