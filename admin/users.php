<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){
    header('Location: login.php');
}
if(isset($_GET['deluser']) && $_GET['deluser']!='1'){
    try{
        $stmt = $db->prepare('DELETE FROM blog_members where memberID= ?');
        $stmt->execute(array($_GET['deluser']));
        header('Location: users.php?action=deleted');
        exit;
    }catch(PDOException $e){
        $e->getMessage();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Users</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
    <script language="JavaScript" type="text/javascript">
        function deluser(memberID,username) {
            if (confirm('Bạn có muốn xóa "'+username+'" không ?')) {
                window.location.href = 'users.php?deluser=' + memberID;
            }
        }
    </script>
</head>
<body>
<?php include('menu.php');?>
<section class="container">
    <div clas="row col-sm-8">
    <?php 
        if(isset($_GET['action'])){
            echo '<h3>User '.$_GET['action'].'</h3>';
        }
    ?>
    <table border="1">
        <tr>
            <th width="25%">Member ID</th>
            <th width="25%">Username</th>
            <th width="25%">Email</th>
            <th width="25%">Action</th>
        </tr>
    <?php
    try{
        $stmt = $db->query('select memberID, username, email from blog_members');
        while($row = $stmt->fetch()) {
            echo '<tr>';
            echo '<td>' .$row['memberID'].'</td>';
            echo '<td>' .$row['username'].'</td>';
            echo '<td>' .$row['email'].'</td>';
    ?>

            <td><a href="edit-user.php?id=<?php echo $row['memberID']; ?>">Edit|</a>
                <?php if($row['memberID']!=1){?>
                <a href="javascript:deluser('<?php echo $row['memberID']; ?>','<?php echo $row['username']; ?>')">Delete</a></td>
    <?php }
        echo '</tr>';
        }
    } catch(PDOException $e){
        $e->getMessage();
    }
    ?>
    </table>
    <a href="add-user.php">Add new user</a>
    </div>
</section>

</body>
</html>