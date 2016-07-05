<?php
    $link = mysql_connect('host', 'user', 'pass');
    
    if(!$link){
        die('database connection failed');
    }
    
    if(! mysql_select_db('database', $link)) {
        die('database connection failed');
    }
    
?>
