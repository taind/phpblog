<?php
require_once ('../includes/config.php');
if(!$user->is_logged_in()){
    header('Location: index.php');
}
if(isset($_GET['delcat'])){ //delte category
    $stmt2 = $db->prepare('DELETE FROM blog_cats where catID = ?');
    $stmt2->execute(array($_GET['delcat']));
    header('Location: categories.php?action=deleted');
    exit;
}
if(isset($_POST['addcat'])){ // add category
    $_POST = array_map('stripslashes',$_POST);
    extract($_POST);
    if($newcatname == ''){
        $error= 'error in new category name';
    }
    if(!isset($error)){
        $catSlug = slug($newcatname);
        $stmt3 = $db->prepare('INSERT INTO blog_cats (catTitle,catSlug) VALUES (?,?)');
        $stmt3->execute(array($newcatname,$catSlug));
        header('Location: categories.php?action=added');
        exit;
    }
}
if(isset($_POST['editcat'])){ //edit category
    $_POST = array_map('stripslashes',$_POST);
    extract($_POST);
    if($newcatname == ''){
        $error= 'error in new category name';
    }
    $catSlug = slug($newcatname);
    $stmt4 = $db->prepare('UPDATE blog_cats SET catTitle=?,catSlug=? WHERE catID= ?');
    $stmt4->execute(array($newcatname,$catSlug,$catID));
    header('Location: categories.php?action=updated');
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Categories</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
    <script src="../jquery.js"></script>
    <script language="JavaScript" type="text/javascript">
        function delcat(catID,catTitle) { //bấm nút delete
            if (confirm('Bạn có muốn xóa "'+catTitle+'" category không ?')) {
                window.location.href = 'categories.php?delcat=' + catID;
            }
        }
    </script>
    <script> // bấm nút add
        $(document).ready(function () {
           $(".btnadd").click(function () {
                data="<form action='' method='post'>" +
                       "<label>New category: </label>" +
                       "<input type='text' name='newcatname'>" +
                       "<input type='submit' name='addcat' value='Add cat'>" +
                       "</form>";
                $("p").html(data);
                $(".btnadd").hide();
           })
        });
    </script>

    <script> //bấm nút edit
        $(document).ready(function () {
            $(".btnedit").click(function () {
                var value1= $(".btnedit").index(this);
                var value2= $(".btnedit")[value1].value;
                var value3= $(".btnedit")[value1].id;
                data="<form action='' method='post'>" +
                    "<label>Edit category: </label>" +
                    "<input type='text' name='newcatname' value='"+value2+"'>" +
                    "<input type=hidden name='catID' value='"+value3+"'>" +
                    "<input type='submit' name='editcat' value='Update cat'>" +
                    "</form>";
                $("p").html(data);
            })
        });
    </script>
</head>
<body>
<?php include "menu.php"; ?>
<?php
if(isset($error)){
    echo $error;
}
if(isset($_GET['action'])){
    echo 'Category '.$_GET['action'];
}
?>
<table border="1">
    <tr>
        <th>Category</th>
        <th>Action</th>
    </tr>


<?php
$stmt = $db->query('SELECT catID,catTitle from blog_cats order by catID DESC');
while($row = $stmt->fetch()){
    echo '<tr>';
    echo '<td><input type="text" name="txtCatName" value="'.$row['catTitle'].'"></td>';
?>
<td><button class="btnedit" value="<?php echo $row['catTitle']; ?>" id="<?php echo $row['catID']; ?>">Edit</button> |
    <button onclick="delcat('<?php echo $row['catID']; ?>', '<?php echo $row['catTitle']; ?>')">Delete</button></td>
<?php
    echo '</tr>';
}
?>
</table>
<button class="btnadd">Add category</button>
<p class="inner"></p>

</body>
</html>
