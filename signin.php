<?php
    if( !isset($_POST) ) die;
    require_once('include/users.php');
    if( ( check_cookie() !== false ) || ( check_signin($_POST['addr'], $_POST['password']) )  ){
        echo "success";
    }else echo "fail";
?>