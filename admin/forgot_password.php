
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
    <title>Reset password</title>
    <script src="../jquery.js"></script>
    <script>
        $(document).ready(function () {
           $("#reset").click(function () {
                var email = $("#email").val();
                if(email == ''){
                    alert('Please enter your email');
                    exit;
                }
                $.post("reset_password.php",
                    {
                        email:email
                    },
                    function (data,status) {
                        if(status=="success"){
                            $("#message").html(data);
                        }
                    }
               );
           });
        });
    </script>
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
                         <i class="fa fa-bars"></i>
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
            <h2 align="center">Enter you email<h2>
            <input type="text" class="form-control" name="email" id="email">
            <br><input type="submit" name="reset" value="Reset" id="reset" class="btn btn-default">
             <div id="message"></div>
        </figure>
    </div>
</section>
</body>
</html>
