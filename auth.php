<?php ?>
<!DOCTYPE html>
<html lang="">
<head>
<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<?php
    require_once('include/users.php');
    if( ( check_cookie() !== false ) || ( check_signin($_POST) )  ){
            header("Location: /");
            die();
    }else{
?>
<div id="content" class="vertical-center">
<form id="signin" action="" method="POST">
    <div><span>TDCoin address</span><span class="right"><a href="/help_signin.html">Help signing in</a></span></div>
    <input name="addr" id="addr"><br>
    <div><span>Signature</span></div>
    <textarea name="signature" id="signature"></textarea><br>
    <input type="submit" name="action" value="Signin" onclick="validate();" class="right">
</form>
</div>
<?php } ?>
</body>
</html>