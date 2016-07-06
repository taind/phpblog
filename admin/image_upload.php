<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){header('Location: login.php');}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>File upload</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
    <script src="../jquery.js"></script>
    <script>
        $(document).ready(function (){
            $(".btn").click(function (){
                header("Location: image_upload.php");
                exit;
            });
        });
    </script>
    <script>
        function preview(input) {
            if (input.files && input.files[0]) { // nếu input là file và có file
                var reader = new FileReader(); // đọc file
                reader.onload = function (e) { //khi nào reader được sử dụng thì onload sẽ kích hoạt
                    $('#blah').attr('src', e.target.result); // nhúng attribute src với e.target.result
                }
                reader.readAsDataURL(input.files[0]); //reader đọc url của file ảnh, khi này hàm onload đc kích hoạt
            }
        }
        $(document).ready(function () {
            $("#fileToUpload").change(function(){
                preview(this);
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
    <div clas="row col-sm-8">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Select image to upload</label>
                    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required data-validation-required-message="Please select your file">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group col-xs-12">
                    <input type="submit" name="submit" value="Upload" class="btn btn-default">
                </div>
            </div>
            <br><img id="blah"/>

        </form>
        <?php
        if(!isset($_POST['submit'])){
            exit;
        }
        $target_dir = "../images/"; //thư mục up file
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // url của file
        $uploadOk = 1;
        $imageFileType =  pathinfo($target_file, PATHINFO_EXTENSION);

        if(isset($_POST['submit'])){
            //format Array ( [0] => 1848 [1] => 908 [2] => 3 [3] => width="1848" height="908" [bits] => 8 [mime] => image/png )
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']); // get cai file image (neu khong phai image se khong get duoc)
            if($check !== false){ // neeus check ok
                echo "<br>Image type: ".$check['mime']; //check phair image file khong, xuat image type
                $uploadOk = 1;
            }else{
                echo "<br>File is not image";
                $uploadOk = 0;
            }
        }
        //check file ton tai
        if(file_exists($target_file)){
            $uploadOk = 0;
            echo "<br>Sorry, image exists";
        }
        //check file size
        if( $_FILES['fileToUpload']['size'] > 500000 ){ // bit
            echo "<br>File too large";
            $uploadOk = 0;
        }
        //check file type
        if($imageFileType !== "png" && $imageFileType !== "jpg" && $imageFileType !== "jpeg"){
            echo "<br>Sorry, only JPG JPEG PNG is allowed";
            $uploadOk = 0;
        }
        if($uploadOk == 0){
            echo "<br>Sorry your image was not uploaded";
        }else{
            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file)){
                echo "<br>Your image has been uploaded in <br>";
                echo "localhost/phpblog/".str_replace('../','',$target_file);
            }else{
                echo "<br>Error occurs";
            }
        }
        ?>
    </div>
</section>
</body>
</html>