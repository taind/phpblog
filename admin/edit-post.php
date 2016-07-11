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
    <link rel="stylesheet" href="../style/main.css">
    <script src="../tinymce/tinymce.min.js"></script>
    <script src="../tinymce/jquery.tinymce.min.js"></script>    <script>
        tinymce.init({
            selector: "textarea",
            relative_urls : false,
            remove_script_host : false,
            convert_urls : true,
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
<?php include "menu.php"; ?>
<section class="container">
    <div clas="row col-sm-8">
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
                //check post title
                $postslug_new = slug($postTitle);
                $stmt_postSlug = $db->query('select postSlug,postID from blog_posts');
                while($row_slug = $stmt_postSlug->fetch()){
                    if($postslug_new == $row_slug['postSlug'] &&  $row_slug['postID'] != $_GET['id']){
                        $error[] = 'Post Title duplicated !'; // nếu title trùng nhau và khác postID
                        echo $row_slug['postID'];
                        echo $_GET['id'];
                        break; // tức là trường hợp trùng tên trùng post ID thì không sao do nó chính là nó
                    }
                }
                //check content
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
                        $stmt = $db->prepare('UPDATE blog_posts SET postTitle=?, postSlug=?, postDesc=?, postCont=?, postEdit=? where postID=?');
                        $postSlug = slug($postTitle);
                        $stmt->execute(array($postTitle, $postSlug, strip_tags($postDesc), $postCont,date('Y-m-d H:i:s'),$_GET['id'],)); // update post

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
                        echo    '<div class="alert alert-danger">
                                    <strong>'.$zerror.'</strong>
                                 </div>';
                    }
                }
            }
        ?>
    <form action="" method="post">
        <p><label>Post Title</label><br>
            <input type="text" name="postTitle" size="153" value="<?php echo $row['postTitle']; ?>"><br></p>
        <p><br><label>Post Description</label>
            <textarea name="postDesc" rows="10" cols="60"><?php echo $row['postDesc']; ?></textarea></p>
        <p><br><label>Post Content</label>
            <a href="image_upload.php" target="_blank">Upload image</a>
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
    </form>
    </div>
</section>
</body>
</html>