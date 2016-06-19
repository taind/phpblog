<?php
require_once ('../includes/config.php');
if( $user->is_logged_in() ){ header('Location: index.php'); }
if(isset($_POST['submit'])){ // check neu submit
    $username=trim($_POST['username']);
    $password=trim($_POST['password']);
    if($user->login($username,$password)){ // gọi hàm check admin bên user
        header('Location: index.php'); // nếu true thì đưa về admin index
        exit;
    }else{
        echo '<p class="error">Wrong username or password</p>';
    }
}
?>
<html>
<form action="" method="post">
    <p>Username:<input type="text" name="username" value=""></p>
    <p>Password:<input type="text" name="password" value=""></p>
    <input type="submit" name="submit" value="ok">
</form>
</html>
