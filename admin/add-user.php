<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){
    header('Location: login.php');
}
if(isset($_POST['submit'])){
    $_POST = array_map('stripslashes', $_POST);
    extract($_POST);
    if($username == ''){
        $error[] = 'Please enter USERNAME';
    }
    if($email == ''){
        $error[] = 'Please enter EMAIL';
    }
    if($password == ''){
        $error[] = 'Please enter PASSWORD';
    }
    if($password != $repassword){
        $error[] = 'PASSWORD is not same';
    }
    if(!isset($error)){
        $stmt = $db->prepare('INSERT INTO blog_members (username,email,password) VALUES (?,?,?)');
        $stmt->execute(array($username,$email,$password));
        header('Location: users.php?action=added');
        exit;
    }
    if(isset($error)){
        foreach($error as $zerror){
            echo '<p>'.$zerror.'</p>';
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Add User</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<?php
if(isset($_GET['action'])){
    echo '<h3>User '.$_GET['action'].'</h3>';
}
?>
<form action="" method="post">
    <p><label>Username<label>
                <input type="text" name="username" value="<?php if(isset($error)) echo $_POST['username']; ?>"></p>
    <p><label>Email<label>
                <input type="text" name="email" value="<?php if(isset($error)) echo $_POST['email']; ?>"></p>
    <p><label>Password<label>
                <input type="password" name="password" value=""></p>
    <p><label>Re-password<label>
                <input type="password" name="repassword" value=""></p>
    <input type="submit" name="submit" value="Add User">
</form>
</body>
</html>

