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
<?php include('menu.php');?>
<section class="container">
    <div clas="row col-sm-8">
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

    if($newpassword != ''){
        if($newpassword != $repassword){
            $error[] = 'PASSWORD is not same';
        }
    }else{
        $error[] = 'Please enter your new password';
    }
    if( $cur_password == ''){
        $error[] = 'User current password wrong';
    } else {
        if($cur_password != $row['password']){
            $error[] = 'User current password wrong';
        }
    }

    if(!isset($error)){
        $stmt = $db->prepare('UPDATE blog_members SET password=? where memberID=?');
        $stmt->execute(array($newpassword,$_GET['id']));
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
        <form action="" method="POST" name="sentMessage" id="contactForm" novalidate>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Username:</label>
                    <input type="text" class="form-control" value="<?php echo $row['username']; ?>" name="username" id="username" required data-validation-required-message="Please enter your name." readonly>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Email Address</label>
                    <input type="email" class="form-control" value="<?php echo $row['email']; ?>" name="email" id="email" readonly>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Current Password</label>
                    <input type="password" class="form-control" value="" name="cur_password" id="cur_password">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>New Password</label>
                    <input type="password" class="form-control" value="" name="newpassword" id="newpassword" >
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Re-Password</label>
                    <input type="password" class="form-control" name="repassword" id="repassword">
                    <p class="help-block text-danger"></p>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="form-group col-xs-12">
                    <input type="submit" name="submit" value="Update User" class="btn btn-default">
                </div>
            </div>
        </form>
</div>
</section>
</body>
</html>

