<?php
require_once ("../includes/config.php");
$email = $_POST['email'];
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "Please enter correct email format";
    exit;
}

$stmt = $db->query("select email from blog_members");
while($row = $stmt->fetch()){
    if($row['email'] === $email){ // nếu user nhập email có trong db
        $newpass = rand(1111,9999);
        break;
    }
}
if(!isset($newpass)){ // nếu newpass rỗng tức là ko có trong db
    echo "Your email is not valid";
}else{
    $stmt2 = $db->prepare('UPDATE blog_members SET password=? where email =?');
    $stmt2->execute(array($newpass,$email));
    $to = $email;
    $email_subject = "Reset your password at 20namsau.com";
    $email_body = "You have requested password reset, here your new password: ".$newpass;
    $headers = "From: noreply@20namsau.com\n";
    if(mail($to,$email_subject,$email_body,$headers)){
        echo "Your new password has been sent to your inbox !";
    }else{
        echo "Errors!!";
    }
}
?>