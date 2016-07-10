<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){
    header('Location: login.php');
}
if(isset($_POST['submit'])){
    $_POST = array_map('stripslashes', $_POST);
    extract($_POST);
    $stmt_user = $db->query('select username from blog_members');
    while($row_user = $stmt_user->fetch()){
        if($row_user['username'] === $username){
            $error[] = 'User exist';
        }
    }
    $stmt_email = $db->query('select email from blog_members');
    while($row_email = $stmt_email->fetch()){
        if($row_email['email'] === $email){
            $error[] = 'Email used';
        }
    }
    if($username == ''){
        $error[] = 'Please enter USERNAME';
    }
    if($email == ''){
        $error[] = 'Please enter EMAIL';
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error[]= "Please enter correct email format";
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
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Add User</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<?php include('menu.php');?>
<section class="container">
    <div clas="row col-sm-8">
        <?php
        if(isset($_GET['action'])){
            echo '<p>User '.$_GET['action'].'</p>';
        }
        ?>
        <?php
        if(isset($error)){
            foreach($error as $zerror){
                echo '<p>'.$zerror.'</p>';
            }
        }
        ?>
        <form action="" method="POST" name="sentMessage" id="contactForm" novalidate>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Username:</label>
                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" required data-validation-required-message="Please enter your name.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Email Address</label>
                    <input type="email" class="form-control" placeholder="Email Address" name="email" id="email" required data-validation-required-message="Please enter your email address.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" required data-validation-required-message="Please enter your phone number.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Re-Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="repassword" id="repassword" required data-validation-required-message="Please enter your phone number.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="form-group col-xs-12">
                    <input type="submit" name="submit" value="Add User" class="btn btn-default">
                </div>
            </div>
        </form>
    </div>
</section>
</body>
</html>

