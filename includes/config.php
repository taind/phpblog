<?php
//khai bao connect = PDO
include('function.php');
ob_start(); // khởi tạo bộ đệm cho kq của server
session_start();
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'phpblog');
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
try{
    $db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS, $options);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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