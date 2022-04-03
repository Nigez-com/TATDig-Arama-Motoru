function switch_frm(id){
    closing(id);
    switch(id){
	case 'signinpage': reg_frm(); break;
	case 'regpage':	signin_frm(); break;
    }
}

function signin_frm(){
    var bd = document.body.innerHTML;
    bd = '<div id="signinpage" class="overlay">\
  <div class="login-page"><a class="right close" href="javascript:closing(\'signinpage\');" title="Close sign in form"> X </a>\
  <div class="form">\
    <form class="login-form" method="POST">\
      <input type="text" name="addr" placeholder="TDCoin address"/>\
      <input type="password" name="password" placeholder="Password"/>\
      <input type="hidden" name="action" id="action" value="signin">\
      <button type="button" onclick="signin();">sign in</button>\
      <p class="message">Not registered? <a href="javascript:switch_frm(\'signinpage\');">Create an account</a></p>\
    </form>\
  </div>\
</div>\
</div>\
' + bd;
document.body.innerHTML=bd;
}

function closing(id){
    var elem = document.getElementById(id);
    elem.parentNode.removeChild(elem);
//    return false;
}

function signin(){
    var addr, pwd;
    addr = document.getElementsByName('addr')[0].value;
    pwd = document.getElementsByName('password')[0].value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", '/signin.php', true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() { // Call a function when the state changes.
	if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
    	    // Request finished. Do processing here.
	        if(xhr.readyState == 4 && xhr.status == 200) {
    		    if( xhr.responseText == 'success') {
			document.getElementById('user').innerHTML = '<a href="javascript:signout();" title="Sign out">'+addr+'</a>';
			closing('signinpage'); 
		    }
		    else{ alert(xhr.responseText+"\nPlease check input fields and try again."); }
		}
	}
    }
    xhr.send("addr="+addr+"&password="+pwd+"&action=signin");
    // xhr.send(new Int8Array());
    // xhr.send(document);
}

function reg_frm(){
    var bd = document.body.innerHTML;
    bd = '<div id="regpage" class="overlay">\
<div class="login-page"><a class="right close" href="javascript:closing(\'regpage\');" title="Close registration form"> X </a>\
  <div class="form">\
    <form class="register-form" method="POST">\
      <input name="addr" id="addr" type="text" placeholder="TDCoin address"/>\
      <input type="password" name="password" id="password" placeholder="Password"/>\
      <textarea rows="3" name="signature" placeholder="Signature"></textarea>\
      <input type="hidden" name="action" value="register"><br>\
      <button type="button" onclick="regaddr();">register</button>\
      <p class="message">Already registered? <a href="javascript:switch_frm(\'regpage\');">Sign In</a></p>\
    </form>\
  </div>\
</div>\
    </div>\
    ' + bd;
document.body.innerHTML=bd;
}

function regaddr(){
    var addr, pwd, sign;
    addr = document.getElementsByName('addr')[0].value;
    pwd = document.getElementsByName('password')[0].value;
    sign = document.getElementsByName('signature')[0].value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", '/register.php', true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() { // Call a function when the state changes.
	if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
    	    // Request finished. Do processing here.
	        if(xhr.readyState == 4 && xhr.status == 200) {
    		    if( xhr.responseText == 'success') {
			document.getElementById('user').innerHTML = '<a href="javascript:signout();" title="Sign out">'+addr+'</a>';
			closing('regpage'); 
		    }
		    else{ alert(xhr.responseText+"\nPlease check input fields and try again."); }
		}
	}
    }
    xhr.send("addr="+addr+"&password="+pwd+"&signature="+encodeURIComponent(sign)+"&action=register");
    // xhr.send(new Int8Array());
    // xhr.send(document);
}

function signout(){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", '/signout.php', true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() { // Call a function when the state changes.
	if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
    	    // Request finished. Do processing here.
	        if(xhr.readyState == 4 && xhr.status == 200) {
    		    if( xhr.responseText == 'success') {
			document.getElementById('user').innerHTML = '<a href="javascript:reg_frm();"> Register </a><a href="javascript:signin_frm();"> Signin </a>';
		    }
		    else{ alert(xhr.responseText+"\nPlease check input fields and try again."); }
		}
	}
    }
    xhr.send("addr="+document.getElementById('user').innerHTML);
}
