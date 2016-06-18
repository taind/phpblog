<?php

class User
{
    private $db;
    public function __construct($db_in)
    {
        $this->db=$db_in;
    }
    public function is_logged_in(){
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            return true;
        }
    }
    public function login($username, $password)
    {
        if($username == "admin" && $password == "admin"){
            $_SESSION['loggedin']=true;
            return true;
        }
    }
}
?>