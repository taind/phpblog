<?php
$handle = fopen("includes/hitcounter.txt",'r');
if(!$handle){
    echo "could not open the file" ;
}
else {
    $counter = (int) fread($handle,10);
    fclose($handle);
    $counter++;
    echo "Visitor: ".$counter;
    $handle =  fopen("includes/hitcounter.txt", "w" );
    fwrite($handle, $counter);
    fclose($handle);
}
?>