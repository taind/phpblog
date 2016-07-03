<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
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
    $stmt = $db->prepare("select postID,postDesc,postTitle,postSlug,postDate from blog_posts where postDate>=? and postDate <= ? order by postDate DESC ".$pages->get_limit());
    $stmt->execute(array($from,$to));
    while($row = $stmt->fetch()){
        echo "<div>";
        echo "<h3><a href='".$row['postSlug']."'>".$row['postTitle']."</a></h3>";
        echo "<p>".$row['postDesc']."</p>";
        echo "Post on: ".$row['postDate']." in ";
        try{
            $stmt2 = $db->prepare("select blog_cats.catTitle, blog_cats.catSlug from blog_post_cats,blog_cats where blog_cats.catID=blog_post_cats.catID and blog_post_cats.postID=?");
            $stmt2->execute(array($row['postID']));
            $row_cat = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $links = array();
            foreach($row_cat as $zrow_cat){
                $links[] = "<a href='c-".$zrow_cat['catSlug']."'>".$zrow_cat['catTitle']."</a>";
            }
            echo implode(",", $links);
        }catch (PDOException $eee){
            echo $eee->getMessage();
        }

        echo "<p><a href='".$row['postSlug']."'>Read more</a></p>";
        echo "</div>";

    }
}catch(PDOException $e){
    echo $e->getMessage();
}
//paginator
echo $pages->page_links("a-$month-$year&");
?>
        </figure>
        <figure class="col-sm-3">
            <?php require ("sidebar.php"); ?>
        </figure>
    </div>
</section>
</body>
</html>
