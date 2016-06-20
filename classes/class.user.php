<?php
class User
{
    private $db;
    public function __construct($db_in) //constructor khi user goi $db se duoc truyen vao db
    {
        $this->_db=$db_in;
    }
    public function is_logged_in(){ //check neu user da dang nhap chua
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            return true;
        }
    }

    public function getPassword($username) // lay password trong db voi username user nhap vao
    {
        try {
            $stmt = $this->_db->prepare('select password from blog_members where username= ?');
            $stmt->execute(array($username));
            $row = $stmt->fetch(); // lay dong doc duoc
            return $row['password']; // neu co user thi return passwrod user do
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function login($username, $password)
    {
        $pass = $this->getPassword($username);
        if($password == $pass){
            $_SESSION['loggedin']=true;
            return true;
        }
    }
    public function isAdmin($username){
        if($username == 'admin'){
            return true;
        }
    }
}
?>