<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   || //check post data
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   { //check phải dạng a@b.c hay ko
   echo "No arguments Provided!";
   return false;
   }
   // loại bỏ các kí tự đặc biệt
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// tạo email
$to = 'taind2504@gmail.com';
$email_subject = 'Website Contact From:  $name';
$email_body = 'Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message';
$headers = 'From: noreply@20namsau.com\n';
$headers .= 'Reply-To: $email_address';
mail($to,$email_subject,$email_body,$headers);
return true;         
?>
