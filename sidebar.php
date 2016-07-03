<h3>Recent posts</h3>
<ul>
<?php
try{
    $stmt = $db->query("select postSlug,postTitle from blog_posts order by postID DESC LIMIT 5");
    while($row = $stmt->fetch()){
        echo "<li type='square'><a href='".$row['postSlug']."'>".$row['postTitle']."</a></li>";
    }
    }catch(PDOException $e){
        echo $e->getMessage();
    }

?>
</ul>
<hr>

<h3>Categories</h3>
<ul>
<?php
try{
    $stmt = $db->query("select catSlug,catTitle from blog_cats order by catID DESC");
    while($row = $stmt->fetch()){
        echo "<li type='square'><a href='c-".$row['catSlug']."'>".$row['catTitle']."</a></li>";
    }
}catch(PDOException $e){
    echo $e->getMessage();
}
?>
</ul>
<hr>

<h3>Archives</h3>
<ul>
<?php
try{
    $stmt = $db->query("select Month(postDate) as month, Year(postDate) as year from blog_posts group by Month(postDate), Year(postDate) order by postDate DESC");
    while($row = $stmt->fetch()){
        $a_name = date("F", mktime(0,0,0,$row['month'],10));
        $slug = 'a-'.$row['month']."-".$row['year'];
        echo "<li type='square'><a href='$slug'>".$a_name."-".$row['year']."</a></li>";
    }
}catch(PDOException $e){
    echo $e->getMessage();
}
?>
</ul>
<hr>

