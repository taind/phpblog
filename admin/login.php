<?php
require_once ('../includes/config.php');
if( $user->is_logged_in() ){ header('Location: index.php'); }
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<div id="wrapper">
    <?php
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
<form action="" method="post" id="formlogin">
    <table border="1" id="loginpage">
        <tr><th><p>Username:</p></th><td><input type="text" name="username" value=""></td></tr>
        <tr><th><p>Password:</p></th><td><input type="text" name="password" value=""></td></tr>
    </table>
    <input type="submit" name="submit" value="Login">
</form>
</div>
</body>
</html>
