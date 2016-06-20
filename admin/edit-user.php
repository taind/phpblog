<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){
    header('Location: login.php');
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Edit User</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<form action="" method="post">
    <p><label>Username<label>
    <input type="text" name="username" value=""></p>
    <p><label>Email<label>
    <input type="text" name="email" value=""></p>
    <p><label>Username<label>
    <input type="password" name="password" value=""></p>
    <p><label>Username<label>
    <input type="password" name="repassword" value=""></p>
    <input type="submit" name="submit" value="Update">
</form>
</body>
</html>