<?php
require ('includes/config.php');
$stmt = $db->prepare('Select postID,postDate,postCont,postTitle from blog_posts where postID= ?');
$stmt->execute(array($_GET['id'])); // get id bên index truyen qua va quang vao statement o tren
$row=$stmt->fetch();
if($row['postID'] == ''){
    header('Location: ./');
    exit;
}
//echo '<div>';
//echo '<p>post Title :'.$row['postTitle'].'</p>';
//echo '<p>post on:'.$row['postDate'].'</p>';
//echo '<p>post content: '.$row['postCont'].'</p>';
//echo '</div>';
//?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['postTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

<div id="wrapper">

    <h1>Blog</h1>
    <hr />
    <p><a href="./">Blog Index</a></p>


    <?php
    echo '<div>';
    echo '<h1>'.$row['postTitle'].'</h1>';
    echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
    echo '<p>'.$row['postCont'].'</p>';
    echo '</div>';
    ?>

</div>

</body>
</html>


