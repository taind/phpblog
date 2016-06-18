<?php
//khai bao connect = PDO

ob_start(); // khởi tạo bộ đệm cho kq của server
session_start();
define('DBHOST', '188.166.230.219');
define('DBUSER', 'phpblog');
define('DBPASS', '123');
define('DBNAME', 'phpblog');
try{
    $db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connected";
}catch(PDOException $e){
    echo $e->getMessage();
}
date_default_timezone_set('Asia/Ho_Chi_Minh');

// autoload class function
function __autoload($class){
    $class = strtolower($class);
    $classpath = 'classes/class.'.$class.'.php';
    if (file_exists($classpath)){ //neu file class ton tai
        require_once $classpath; //include class vao
    }
    $classpath = '../classes/class.'.$class.'.php';
    if (file_exists($classpath)){ //neu file class ton tai
        require_once $classpath; //include class vao
    }
    $classpath = '../../classes/class.'.$class.'.php';
    if ( file_exists($classpath)) {
        require_once $classpath;
    }
}
$user = new User($db);
?>