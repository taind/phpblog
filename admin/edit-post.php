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
<?php
    $stmt = $db->prepare('select postTitle, postDesc, postCont from blog_posts where postID = ? ');
    $stmt->execute(array($_GET['id']));
    $row = $stmt->fetch();
?>
<?php
    if(isset($_POST['submit'])){
        $_POST= array_map('stripslashes', $_POST);
        extract($_POST);
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
                $stmt->execute(array($postTitle, $postSlug, $postDesc, $postCont, $_GET['id']));
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
    <p><input type="submit" name="submit" value="Update post"></p>
</form>
</body>
</html>