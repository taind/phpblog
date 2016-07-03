<?php // kiểm tra amin có đăng nhập chưa
require_once ('../includes/config.php');
if(!$user->is_logged_in()){ // nếu chưa thì redirect qua trang login.php de login
    header('Location: login.php');
}
//xử lý action edit or delete
if(isset($_GET['delpost'])){
    $stmt = $db->prepare('DELETE FROM blog_posts where postID= ? '); // delete post
    $stmt->execute(array($_GET['delpost']));
    $stmt = $db->prepare('DELETE FROM blog_post_cats where postID=?'); // delete post cat trong table post_cats
    $stmt->execute(array($_GET['delpost']));
    header('Location: index.php?action=deleted');
    exit;
}
?>
<!doctype html>
<html>
<head>
    <title>Admin CP</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script language="JavaScript" type="text/javascript">
        function delpost(postID,postTitle){
            if(confirm('Bạn có muốn xóa post "'+postTitle+'" không?')){
                window.location.href='index.php?delpost='+postID;
            }
        }
    </script>
</head>
<body>
<?php include('menu.php');?>
<section class="container">
    <div clas="row col-sm-8">
        <?php
            if(isset($_GET['action'])){
                echo '<h3>Post '.$_GET['action'].'.</h3>';
            }
        ?>
        <a href="add-post.php">Add new post</a>

        <table border="1">
        <tr>
            <th width="33%">Title</th>
            <th width="33%">Post on</th>
            <th width="33%">Action</th>
        </tr>
        <?php
        try{
            $pages = new Paginator('10', 'p');
            $stmt = $db->query('select postID from blog_posts ORDER BY postID DESC');
            $pages->set_total($stmt->rowCount());
            $stmt = $db->query('select postID, postTitle,postDate from blog_posts ORDER BY postID DESC '.$pages->get_limit());
            while($row=$stmt->fetch()){
                echo    '<tr>';
                if(strlen($row['postTitle']) > 70){
                    $shortedTitle = substr($row['postTitle'],0,70);
                    $shortedTitle .= "...";
                } else {
                    $shortedTitle = $row['postTitle'];
                }
                echo    '<td>'.$shortedTitle.'</td>';
                echo    '<td>'.date('jS M Y H:i A', strtotime($row['postDate'])).'</td>';
        ?>
                        <td>
                            <a href="edit-post.php?id=<?php echo $row['postID']; ?>">Edit | </a>
                            <a href="javascript:delpost('<?php echo $row['postID']; ?>', '<?php echo $row['postTitle']; ?>')">Delete</a>
                        </td>
        <?php
                echo '</tr>';
            }
            echo "</table>";
        }catch(PDOException $e){
            $e->getMessage();
        }
        echo "<div class='span7 center'>";
        echo "<p>".$pages->page_links()."</p>";
        echo "</div>";
        ?>
     </div>
</section>
</body>
</html>