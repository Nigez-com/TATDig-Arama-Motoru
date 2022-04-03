<?php
    if( !isset($_POST) ) die;
//    error_log(json_encode($_POST));
    require_once('include/users.php');
    require_once('include/ldap.php');

    function user_change($tdcaddr, $paswd){
	// if user exists in LDAP set password
	// if user doesn't in LDAP exists add new user with password
	error_log('user_change');
	add_user($tdcaddr,$paswd);
    }

try{
    if( ( check_register($_POST['addr'], $_POST['password'], $_POST['signature']) ) ){
            set_cookie( encrypt_str($_POST['addr']) );
            user_change($_POST['addr'], $_POST['password']);
            echo "success";
    } else echo "fail";
}
catch(Exception $e) {
    error_log($e->getMessage());
    echo "fail";
}
?>
