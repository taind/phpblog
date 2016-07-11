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
            if($_GET['action']== 'added' || $_GET['action']== 'updated'){
                echo    '<div class="alert alert-success">
                                <strong>Post '.$_GET['action'].'</strong>
                            </div>';
            }
            if($_GET['action']== 'deleted'){
                echo '  <div class="alert alert-danger">
                                <strong>Post '.$_GET['action'].'</strong>
                            </div>';
            }
        }
        ?>
        <a href="add-post.php">Add new post</a>

        <table class="table">
            <tr>
                <th width="30%">Title</th>
                <th width="10%">View</th>
                <th width="15%">Author</th>
                <th width="15%">Post on</th>
                <th width="15%">Last Edited</th>
                <th width="15%">Action</th>
            </tr>
            <?php
            try{
                $pages = new Paginator('10', 'p');
                $stmt = $db->query('select postID from blog_posts ORDER BY postID DESC');
                $pages->set_total($stmt->rowCount());
                $stmt = $db->query('select postID, postSlug, postTitle,postDate,postAuthor,postEdit,postView from blog_posts ORDER BY postID DESC '.$pages->get_limit());
                while($row=$stmt->fetch()){
                    echo    '<tr>';
                    if(strlen($row['postTitle']) > 60){
                        $shortedTitle = substr($row['postTitle'],0,60);
                        $pos = strrpos($shortedTitle,' ');
                        $shortedTitle = substr($row['postTitle'],0,$pos +1);
                        $shortedTitle .= " ...";
                    } else {
                        $shortedTitle = $row['postTitle'];
                    }
                    echo    '<td><a href="../'.$row['postSlug'].'" target="_blank" >'.$shortedTitle.'</td>';
                    echo    '<td>'.$row['postView'].'</td>';
                    echo    '<td>'.$row['postAuthor'].'</td>';
                    echo    '<td>'.date('jS M Y H:i A', strtotime($row['postDate'])).'</td>';
                    echo    '<td>'.date('jS M Y H:i A', strtotime($row['postEdit'])).'</td>';
                    echo    '<td>';
                    if($_SESSION['username']!= 'admin'){
                        if($_SESSION['username'] == $row['postAuthor']){
                            ?>
                            <a href='edit-post.php?id=<?php echo $row['postID']; ?>' > Edit | </a>
                            <a href='javascript:delpost("<?php echo $row['postID']; ?>","<?php echo $row['postTitle']; ?>")'>Delete</a>
                    <?php    }
                    }else{
                        ?>
                        <a href='edit-post.php?id=<?php echo $row['postID']; ?>' > Edit | </a>
                        <a href='javascript:delpost("<?php echo $row['postID']; ?>","<?php echo $row['postTitle']; ?>")'>Delete</a>
                    <?php
                    }

                    echo    '</td>';

                    echo '</tr>';
                }
                echo "</table>";
                echo "<div>";
                $stmt_total = $db->query('select count(postID) as slp from blog_posts');
                $row_total = $stmt_total->fetch();
                echo "Total post: ".$row_total['slp'];
                $stmt_totalv = $db->query('select sum(postView) as slv from blog_posts');
                $row_totalv = $stmt_totalv->fetch();
                echo "<br>Total post view: ".$row_totalv['slv'];
                echo "</div>";
            }catch(PDOException $e){
                $e->getMessage();
            }
            echo "<p>".$pages->page_links()."</p>";
            echo "</div>";
            ?>
    </div>
</section>
</body>
</html>