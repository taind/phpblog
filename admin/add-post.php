<?php
require_once('../includes/config.php');
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin - Add Post</title>
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
    <?php include('menu.php');?>
    <p><a href="/">Blog Admin Index</a></p>
    <h2>Add Post</h2>
</div>
<?php
    if(isset($_POST['submit'])){ //form submit ?
        $_POST = array_map('stripslashes', $_POST); //bỏ các dấu xoẹt
        extract($_POST); // tách array ra
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
                $stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postSlug,postDesc,postCont,postDate) VALUES (?,?,?,?,?)');
                $postSlug = slug($postTitle);
                $stmt->execute(array($postTitle,$postSlug,$postDesc,$postCont, date('Y-m-d H:i:s')));
                header('Location: index.php?action=added');
                exit;
            }catch(PDOException $e){
                $e->getMessage();
            }
        }
        if(isset($error)){
            foreach ($error as $zerror)
                echo '<p>'.$zerror.'</p>';
        }
    }


?>
<form action="" method="post">
    <p><label>Post Title</label><br>
    <input type="text" name="postTitle" value="<?php if(isset($error)){ echo $_POST['postTitle'];}?>"><br></p>
    <p><label>Post Description</label>
    <textarea name="postDesc" rows="10" cols="60"><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>
    <p><label>Post Content</label>
    <textarea name="postCont" rows="10" cols="60"><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
    <p><input type="submit" name="submit" value="Add post"></p>
</form>
</body>
</html>