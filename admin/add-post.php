<?php
require_once('../includes/config.php');
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin - Add Post</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
    <script src="../tinymce/tinymce.min.js"></script>
    <script src="../tinymce/jquery.tinymce.min.js"></script>
    <script>
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

<?php include('menu.php');?>
<section class="container">
    <div clas="row col-sm-8">
        <?php
        if(isset($_POST['submit'])){ //form submit ?
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
                try {
                    $stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postSlug,postDesc,postCont,postDate,postAuthor) VALUES (?,?,?,?,?,?)');
                    $postSlug = slug($postTitle);
                    $stmt->execute(array($postTitle,$postSlug,strip_tags($postDesc),$postCont, date('Y-m-d H:i:s'), $_SESSION['username'])); // add post vào blog_post
                    $stmt = $db->query('Select max(postID) as mpostID from blog_posts');
                    $row = $stmt->fetch();
                    $postID = $row['mpostID']; // lấy cái postID của thằng mới add vào, nó lớn nhất
                    foreach($temp_catID as $catID){ // duyệt mảng catID
                        $stmt2 = $db->prepare('INSERT INTO blog_post_cats (postID,catID) VALUES (?,?)');
                        $stmt2->execute(array($postID,$catID)); // add vào blog_post_cats với postID và cat ID
                    }
                    header('Location: index.php?action=added');
                    exit;
                }catch(PDOException $e){
                    $e->getMessage();
                }
            }
            if(isset($error)){
                foreach ($error as $zerror)
                    echo    '<div class="alert alert-danger">
                                <strong>'.$zerror.'</strong>
                            </div>';
            }
        }


        ?>
        <form action="" method="post">
            <p><label>Post Title</label><br>
                <input type="text" size="100%" name="postTitle" value="<?php if(isset($error)){ echo $_POST['postTitle'];}?>"><br></p>
            <p><br><label>Post Description</label>
                <textarea name="postDesc" rows="10" cols="60"><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>
            <p><br><label>Post Content</label>
                <a href="image_upload.php" target="_blank">Upload image</a>
                <textarea name="postCont" rows="10" cols="60"><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
            <h4>Categories</h4>
            <?php
            $stmt_cats = $db->query('SELECT catID,catTitle FROM blog_cats ORDER BY catTitle');

            while($row_cats = $stmt_cats->fetch()){
                if(isset($_POST['catID'])){
                    if(in_array($row_cats['catID'],$_POST['catID'])){
                        echo "<input type='checkbox' name='catID[]' value='".$row_cats['catID']."' checked>".$row_cats['catTitle']."<br />";
                    } else{
                        echo "<input type='checkbox' name='catID[]' value='".$row_cats['catID']."'>".$row_cats['catTitle']."<br />";
                    }
                } else{
                    echo "<input type='checkbox' name='catID[]' value='".$row_cats['catID']."'>".$row_cats['catTitle']."<br />";
                }
            }
            ?>
            <p><input type="submit" name="submit" value="Add post"></p>
        </form>
    </div>
</section>
</body>
</html>