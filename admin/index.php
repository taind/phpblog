<?php // kiểm tra amin có đăng nhập chưa
require_once ('../includes/config.php');
if(!$user->is_logged_in()){ // nếu chưa thì redirect qua trang login.php de login
    header('Location: login.php');
}
//xử lý action edit or delete
if(isset($_GET['delpost'])){
    $stmt = $db->prepare('DELETE FROM blog_posts where postID= ? ');
    $stmt->execute(array($_GET['delpost']));
    header('Location: index.php?action=deleted');
    exit;
}
?>
<!doctype html>
<html>
<head>
    <title>Admin CP</title>
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
<?php
    if(isset($_GET['action'])){
        echo '<h3>Post '.$_GET['action'].'.</h3>';
    }
?>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Post on</th>
        <th>Action</th>
    </tr>
    <?php
    try{
        $stmt = $db->query('select postID, postTitle,postDate from blog_posts ORDER BY postID DESC');
        while($row=$stmt->fetch()){
            echo    '<tr>';
            echo    '<td>'.$row['postTitle'].'</td>';
            echo    '<td>'.$row['postDate'].'</td>';
    ?>
                    <td>
                        <a href="edit-post.php?id=<?php echo $row['postID']; ?>">Edit | </a>
                        <a href="javascript:delpost('<?php echo $row['postID']; ?>', '<?php echo $row['postTitle']; ?>')">Delete</a>
                    </td>
    <?php
            echo '</tr>';
        }
    }catch(PDOException $e){
        $e->getMessage();
    }
 ?>
    <a href="add-post.php">Add new post</a>
</table>
</body>
</html>