<!DOCTYPE html>
<html lang="">
<head>
<link rel="stylesheet" type="text/css" href="/css/style.css">
<script>
function toclipboard(){
  text = '{"action": "authenticate","website": "nigez.com"}';
  if(!navigator.clipboard){
    fallbackCopyTextToClipboard(text);
    return;
  }
  navigator.clipboard.writeText(text).then(function(){
    console.log('Async: Copying to clipboard was successful!');
  }, function(err) {
    console.error('Async: Could not copy text: ', err);
  });
}
</script>
</head>
<style>
    img{max-width:100%}
</style>
<body>
<div id="content"<center>
<h1 id="registration">Help > Register</h1><br>
 <p>Authencation is based on TDCoin blockchain. 
    Using this method allows our users to keep total control over their privacy. 
    To register on the website please utilize only "legacy" address. 
    Legacy addresses starts with "T". For example "TBKt61V7HBo1R6iWGsAqijgc4vZchK2Rmj".
 </p><br>
 <p><a href="https://tdcoincore.org/download/0_18/">Download</a> and install TDCoinCore client software to your computer.</p>
 <p>Start the application.</p>
 <p><h2>Creating authentication signature using TDCoin Core application</h2> Please use menu "File->Sign message" in main menu of the application.</p><br>
 <img src="/images/help/menu.png" alt="TDCoin Core application window"><br>
 <p>Select address you want to use for signing in. Only use "legacy" adressess.</p><br>
 <img src="/images/help/screen2.png" alt="TDCoin Core application window, address selection"><br>
 <img src="/images/help/screen3.png" alt="TDCoin Core application window, address selection"><br>
 <p>Use this "<span class="red">{"action": "authenticate","website": "nigez.com"}</span>" string for creating authenticating signature and press "Sign message".</p>
 <p>Click here <img class="icon" onclick="toclipboard();" src="../images/help/copy.svg"> to put string into a clipboard.</p><br>
 <img src="/images/help/screen4.png" alt="TDCoin Core application window, address selection"><br>
 <p>Paste or type text as shown above.</p>
 <p>Use button to copy signature and use it on the website.</p><br>
 <img src="/images/help/screen5.png" alt="TDCoin Core application window, address selection"><br>
 <p>Please make a new password and fill out registration form.</p>
 <img src="/images/help/screen6.png" alt="Website registration form, address input"><br>
 <p>If provided information in the form is correct account will be created.
    Your browser will be redirected to start page of the website.</p>

<h1 id="sign_in">Help > Signing in</h1><br>
 <p>To sign in please use wallet address and password used during registration.</p>
 <img src="/images/help/screen7.png" alt="Website sign in form, address password input"><br>
</center></div>
</div>
</body>
</html>