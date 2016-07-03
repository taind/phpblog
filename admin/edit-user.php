<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){header('Location: login.php');}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Edit User</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<div id="wrapper">

<?php include('menu.php');?>
<p><a href="users.php">User Admin Index</a></p>
<h2>Edit User</h2>
<?php
    $stmt = $db->prepare('SELECT username,password,email from blog_members where memberID = ? ');
    $stmt->execute(array($_GET['id']));
    $row = $stmt->fetch();
?>
<?php
if(isset($_POST['submit'])){
    extract($_POST);
    if($username == ''){
        $error[] = 'Please enter USERNAME';
    }
    if($email == ''){
        $error[] = 'Please enter EMAIL';
    }
    if($password != ''){
        if($password != $repassword){
            $error[] = 'PASSWORD is not same';
        }
    }
    if( $currentpass == ''){
        $error[] = 'User current password wrong';
    } else {
        if($currentpass != $row['password']){
            $error[] = 'User current password wrong';
        }
    }

    if(!isset($error)){
        $stmt = $db->prepare('UPDATE blog_members SET username=?,email=?,password=? where memberID=?');
        $stmt->execute(array($username,$email,$password,$_GET['id']));
        header('Location: users.php?action=updated');
        exit;
    }
    if(isset($error)){
        foreach($error as $error){
            echo '<p>'.$error.'</p>';
        }
    }
}
?>
<form action="" method="post">
    <p><label>Username<label>
                <input type="text" name="username" value="<?php echo $row['username']; ?>"></p>
    <p><label>Email<label>
                <input type="text" name="email" value="<?php echo $row['email']; ?>"></p>
    <p><label>Current password<label>
                <input type="password" name="currentpass" value=""></p>
    <p><label>New Password<label>
                <input type="password" name="password" value=""></p>
    <p><label>Re-password<label>
                <input type="password" name="repassword" value=""></p>
    <input type="submit" name="submit" value="Update User">

</form>
</div>
</body>
</html>

