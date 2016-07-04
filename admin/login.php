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
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="row">
            <div class="col-md-2">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        Menu <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.php">Team Vizion</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class='clear'></div>
<hr />
<hr />
<section class="container">
    <div clas="row">
        <figure class="col-sm-4">
        </figure>
        <figure class="col-sm-4">
        <h2 align="center">Admin login<h2>

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
                <form action="" method="POST" name="sentMessage" id="contactForm" novalidate>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Username:</label>
                            <input type="text" class="form-control" name="username" required data-validation-required-message="Please enter your username.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password" required data-validation-required-message="Please enter your password.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <input type="submit" name="submit" value="Login" class="btn btn-default">
                        </div>
                    </div>
                </form>
    </figure>
</div>
</section>
</body>
</html>
