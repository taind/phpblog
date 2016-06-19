<?php
require('includes/config.php');
try {
    $stmt = $db->query("Select postID, postTitle, postDate, postDesc from blog_posts order by postID DESC");
    while ($row = $stmt->fetch()){
        echo '<div>';
        echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>'; // truyen bien postID vao .php?id= <- get method
        echo '<p>Post Desc : '.$row['postDesc'].'</p>';
        echo '<p>Post on : '.$row['postDate'].'</p>';
        echo '<a href="viewpost.php?id='.$row['postID'].'">Read more</a>';
        echo '</div>';
    }

}catch(PDOException $e){
    echo $e->getMessage();
}
?>