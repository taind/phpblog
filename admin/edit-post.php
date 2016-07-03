<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){
    header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin - Edit Post</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
</head>
<body>
<div id="wrapper">

<?php
    $stmt = $db->prepare('select postTitle, postDesc, postCont from blog_posts where postID = ? ');
    $stmt->execute(array($_GET['id']));
    $row = $stmt->fetch();
?>
<?php
    if(isset($_POST['submit'])){
        if(isset($_POST['catID'])){ // trong post nó catID
            $temp_catID = array(); // khai báo mảng tạm
            $temp_catID = $_POST['catID']; // gán mảng category vào biến tạm
        }else{
            $error[] = 'Please select category';
        }
        $postTitle = $_POST['postTitle'];
        $postCont = $_POST['postCont'];
        $postDesc = $_POST['postDesc'];
        if($postTitle == ''){
            $error[] = 'Please enter title!';
        }
        if($postCont == ''){
            $error[] = 'please enter post content!';
        }
        if($postDesc == ''){
            $error[] = 'Please enter post desciption!';
        }
        if(!isset($error)){
            try{
                $stmt = $db->prepare('UPDATE blog_posts SET postTitle=?, postSlug=?, postDesc=?, postCont=? where postID=?');
                $postSlug = slug($postTitle);
                $stmt->execute(array($postTitle, $postSlug, $postDesc, $postCont, $_GET['id'])); // update post

                $stmt = $db->prepare('DELETE FROM blog_post_cats where postID = ?');
                $stmt->execute(array($_GET['id'])); // xóa hết các post cat cũ của postID mình chọn
                foreach($temp_catID as $catID){
                    $stmt = $db->prepare('INSERT INTO blog_post_cats (postID, catID) VALUES (?,?)');
                    $stmt->execute(array($_GET['id'],$catID));
                }
                header('Location: index.php?action=updated');
                exit;
            }catch(PDOException $e){
                $e->getMessage();            }

        }
        if(isset($error)){
            foreach($error as $zerror){
                echo '<p>'.$zerror.'</p>';
            }
        }
    }
?>
<form action="" method="post">
    <p><label>Post Title</label><br>
        <input type="text" name="postTitle" value="<?php echo $row['postTitle']; ?>"><br></p>
    <p><label>Post Description</label>
        <textarea name="postDesc" rows="10" cols="60"><?php echo $row['postDesc']; ?></textarea></p>
    <p><label>Post Content</label>
        <textarea name="postCont" rows="10" cols="60"><?php echo $row['postCont']; ?></textarea></p>
    <?php
    $stmt_cats = $db->query('SELECT catID,catTitle FROM blog_cats ORDER BY catTitle'); // lấy đanh sách category

    $stmt_post_cat = $db->prepare('select catID from blog_post_cats where postID = ?'); // lấy post category
    $stmt_post_cat->execute(array($_GET['id']));
    $post_cat_temp = array(); // gán cat post get được vào mảng temp cho dễ duyệt
    while($row_post_cat = $stmt_post_cat->fetch()){
        $post_cat_temp[] = $row_post_cat['catID'];
    }
    // duyệt 2 mảng
    while($row_cats = $stmt_cats->fetch()){
        $checkpoint = '0';
        foreach( $post_cat_temp as $post_catID){
            if($row_cats['catID'] == $post_catID){
                echo "<input type='checkbox' name='catID[]' value='".$row_cats['catID']."' checked>".$row_cats['catTitle']."<br />";
                $checkpoint = '1';
                break; // nếu mấy post có post cat thì echo ra input checked và gán flag = 1 rồi break luôn
            }
        }
        if($checkpoint != '1'){ // nếu không có thằng nào hết thì tức là flag khác 1, mình echo ra 1 input ko checked
            echo "<input type='checkbox' name='catID[]' value='".$row_cats['catID']."'>".$row_cats['catTitle']."<br />";
            $checkpoint = '0'; // set lại flag để duyệt tiếp
        }


    }
    ?>
    <p><input type="submit" name="submit" value="Update post"></p>
</div>
</form>
</body>
</html>