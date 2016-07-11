<?php
require ("../includes/config.php");
$key = $_POST['keyword'];
$arrayKey = explode(' ',$key);
$searchKey = array();
foreach($arrayKey as $zarrayKey){ // duyệt mảng key
    $zarrayKey = trim($zarrayKey); //bỏ space
    if(!empty($zarrayKey)){ // nếu key ko rỗng
        $searchKey[] = "postSlug like \"%$zarrayKey%\"";
    }
}
?>
<table class="table">
    <tr>
        <th width="30%">Title</th>
        <th width="10%">View</th>
        <th width="15%">Author</th>
        <th width="15%">Post on</th>
        <th width="15%">Last Edited</th>
        <th width="15%">Action</th>
    </tr>
<?php
try{
    $stmt = $db->query('select postID, postSlug, postTitle,postDate,postAuthor,postEdit,postView from blog_posts where '.implode(' or ',$searchKey));
    while($row=$stmt->fetch()){
                    echo    '<tr>';
                    if(strlen($row['postTitle']) > 60){
                        $shortedTitle = substr($row['postTitle'],0,60);
                        $pos = strrpos($shortedTitle,' ');
                        $shortedTitle = substr($row['postTitle'],0,$pos +1);
                        $shortedTitle .= " ...";
                    } else {
                        $shortedTitle = $row['postTitle'];
                    }
                    echo    '<td><a href="../'.$row['postSlug'].'" target="_blank" >'.$shortedTitle.'</td>';
                    echo    '<td>'.$row['postView'].'</td>';
                    echo    '<td>'.$row['postAuthor'].'</td>';
                    echo    '<td>'.date('jS M Y H:i A', strtotime($row['postDate'])).'</td>';
                    echo    '<td>'.date('jS M Y H:i A', strtotime($row['postEdit'])).'</td>';
                    echo    '<td>';
                    if($_SESSION['username']!= 'admin'){
                        if($_SESSION['username'] == $row['postAuthor']){
                            ?>
                            <a href='edit-post.php?id=<?php echo $row['postID']; ?>' > Edit | </a>
                            <a href='javascript:delpost("<?php echo $row['postID']; ?>","<?php echo $row['postTitle']; ?>")'>Delete</a>
                    <?php    }
                    }else{
                        ?>
                        <a href='edit-post.php?id=<?php echo $row['postID']; ?>' > Edit | </a>
                        <a href='javascript:delpost("<?php echo $row['postID']; ?>","<?php echo $row['postTitle']; ?>")'>Delete</a>
                    <?php
                    }

                    echo    '</td>';

                    echo '</tr>';
                }
                echo "</table>";
}catch(PDOException $e){
    $e->getMessage();
}
?>