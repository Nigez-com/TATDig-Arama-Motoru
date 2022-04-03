<?php

function connect_ldap(){
    // Connecting to LDAP
    $ldapconn = ldap_connect(LDAP_URI)
          or error_log("That LDAP-URI was not parseable");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_bind($ldapconn, BIND_DN, BIND_PW);
    error_log(ldap_error($ldapconn)."\n");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    return $ldapconn;
}


/*$s = ldap_search($ldapconn, "DC=nigez,DC=com", "uid=azakir");
echo(ldap_count_entries($ldapconn, $s)."\n");
$data = ldap_get_entries($ldapconn, $s);
echo implode(',',$data[0]['cn']).PHP_EOL;*/

function get_maxuid(){
    $ldap = connect_ldap();
    $filter='(&(objectClass=posixAccount)(uidnumber=*))';
    $attributes=array('uidNumber');
    $search = ldap_search($ldap,BASE_DN,$filter,$attributes);
    $result = ldap_get_entries($ldap, $search);
    foreach($result as $entry){
	//var_dump($entry);
	$res[] = $entry['uidnumber'][0];
    }
    return max($res);
}

function is_user_exists($username){
    $ldapconn = connect_ldap();
    $ldap_success = false;
//if (@ldap_bind($ldapconn, $searchUser, $searchPass)) {
    $attributes = ['cn'];
    $filter = "(&(objectClass=posixAccount)(uid=".ldap_escape($username, null, LDAP_ESCAPE_FILTER)."))";
    $results = @ldap_search($ldapconn, BASE_DN, $filter, $attributes);
    $info = @ldap_get_entries($ldapconn, $results);
    $ldap_success = ($info && $info['count'] === 1);
    return $ldap_success;
//}
}

function add_user($username,$pwd){
    $ldap = connect_ldap();
    if(!is_user_exists($username)){
        error_log("adding user $username to LDAP");
    // put user in objectClass inetOrgPerson so we can set the mail and phone number attributes
//    $ldaprecord['objectclass'][0] = "posixAccount";
        $ldaprecord['objectclass'][0] = "inetOrgPerson";
//    $ldaprecord['objectclass'][1] = "organizationalPerson";
        $ldaprecord['objectclass'][1] = "person";
        $ldaprecord['objectclass'][2] = "posixAccount";

        $ldaprecord['cn'] = $username;
        $ldaprecord['givenName'] = $username;
        $ldaprecord['sn'] = $username;
        $ldaprecord['mail'] = $username."@".DOMAIN;
        $ldaprecord['uid'] = $username;
        $uidnum = get_maxuid()+1;
        $ldaprecord['uidNumber'] = "$uidnum";
        $ldaprecord['gidNumber'] = "10001";
        $ldaprecord['homeDirectory'] = "/tmp";
//    $ldaprecord['givenName'] = $newuser_firstname;
//    $ldaprecord['sn'] = $newuser_surname;
//var_dump($ldaprecord);
//    $ldaprecord['mail'] = $newuser_email_address;
//    $ldaprecord['telephoneNumber'] = $newuser_phone_number;
    // and now the tricky part, base64 encode the binary hash result:
    //$ldaprecord['userPassword'] = '{MD5}' . base64_encode(pack('H*',$newuser_md5hashed_password));
    // If you have the plain text password instead, you could use:
        $ldaprecord['userPassword'] = '{MD5}' . base64_encode(pack('H*',md5($pwd)));
        $r = ldap_add($ldap, "CN=$username, ".USERS_OU, $ldaprecord);
    }else{
        error_log("setting password for $username in LDAP");
        $ldaprecord['userPassword'] = '{MD5}' . base64_encode(pack('H*',md5($pwd)));
        $r = ldap_mod_replace($ldap,"CN=$username, ".USERS_OU, $ldaprecord);
    }
}

function checkUser($dn, $pwd){
    $ldapconn = connect_ldap();
    return ldap_bind($ldapconn, $dn, $pwd);
}

// Set debugging
//ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);

//add_user("BlahBlah","BlahBlah");
//echo(get_maxuid().PHP_EOL);
//echo ( checkUser("cn=TFqfUccXp9jin7G9bhtDaXBqLLzREhkZJ9,ou=TDCoinUsers,dc=nigez,dc=com","123456")?'Succ':'Fail').PHP_EOL;
?>