<?php
require ('index.php');
$stmt = $db->prepare('Select postID,postDate,postContent,postTitle from blog_posts where postID= ?');
$stmt->execute(array($_GET['id'])); // get id bên index truyen qua va quang vao statement o tren
$row=$stmt->fetch();
if($row['postID']==null){
    header('Location: ./');
    exit;
}
echo '<div>';
echo '<p>post Title :'.$row['postTitle'].'</p>';
echo '<p>post on:'.$row['postDate'].'</p>';
echo '<p>post content: '.$row['postContent'].'</p>';
?>