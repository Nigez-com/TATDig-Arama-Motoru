<?php
require __DIR__ . "/vendor/autoload.php";

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;

require_once(__DIR__."/config.inc.php");
function encrypt_str($data){
// Store a string into the variable which
// need to be Encrypted
$simple_string = $data;

// Display the original string
//echo "Original String: " . $simple_string;

// Store the cipher method
$ciphering = "AES-128-CTR";

// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;

// Non-NULL Initialization Vector for encryption
$encryption_iv = '1271567891011121';

// Store the encryption key
$encryption_key = "tdcoin";

// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);

// Display the encrypted string
return $encryption;
}

function decrypt_str($data){

// Store the cipher method
$ciphering = "AES-128-CTR";

// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;

// Non-NULL Initialization Vector for decryption
$decryption_iv = '1271567891011121';
  
// Store the decryption key
$decryption_key = "tdcoin";
  
// Use openssl_decrypt() function to decrypt the data
$decryption=openssl_decrypt ($data, $ciphering, $decryption_key, $options, $decryption_iv);
  
// Display the decrypted string
return $decryption;
}

function checkSignature($address, $signature,$signBody = '{"action": "authenticate","website": "nigez.com"}'){ 
Bitcoin::setNetwork(
NetworkFactory::tdcoin() ); $addrCreator = new AddressCreator();

//$sig = '-----BEGIN BITCOIN SIGNED MESSAGE-----
$sig = '-----BEGIN CRYPTO SIGNED MESSAGE-----
'.$signBody.'
-----BEGIN SIGNATURE-----
'.$signature.'
-----END CRYPTO SIGNED MESSAGE-----';
//-----END BITCOIN SIGNED MESSAGE-----';
/** @var PayToPubKeyHashAddress $address */
$addr = $addrCreator->fromString($address);

/** @var CompactSignatureSerializerInterface $compactSigSerializer */
$compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
$serializer = new SignedMessageSerializer($compactSigSerializer);

$signedMessage = $serializer->parse($sig);
$signer = new MessageSigner();
if ($signer->verify($signedMessage, $addr, Bitcoin::getNetwork())) {
    return true;
} else {
    return false;
}
}

function set_cookie($cookieValue){
setcookie(
    'tdcoin-auth',
    $cookieValue,
    time() + (86400 * 30), // 30 days
    '',
    '',
    false, // Not Only send cookie over HTTPS, never unencrypted HTTP
    false  // expose the cookie to JavaScript
);
}

function unset_cookie(){
setcookie('tdcoin-auth', '', time()-3600);
}

function get_cookie(){
    return ( array_key_exists('tdcoin-auth', $_COOKIE) ?  $_COOKIE['tdcoin-auth'] : "" );
}

function check_cookie(){
    $taddr = decrypt_str(get_cookie());
    if(!empty($taddr)){ return $taddr; } else { return false; }
}

require_once('include/ldap.php');

function check_signin($addr, $pwd){
    $dn  = 'CN='.$addr.',OU=TDCoinUsers,DC=nigez,DC=com';
    //cn=TFqfUccXp9jin7G9bhtDaXBqLLzREhkZJ9,ou=TDCoinUsers,dc=nigez,dc=com
    if( ( (!empty($addr)) && (!empty($pwd)) && checkUser($dn, $pwd) ) ){
	set_cookie( encrypt_str($addr) );
	return true;
    }else{
	return false;
    }
}

function check_register($addr, $pwd, $sign){
    if( !empty($addr) && !empty($pwd) && !empty($sign) && checkSignature($addr, $sign) ){
//	set_cookie( encrypt_str($_POST['addr']) );
//	user_change($_POST['addr'], $_POST['password']);
	return true;
    }else{
	return false;
    }
}

function get_user(){
    $taddr = check_cookie();
    if($taddr !== false){
        return $taddr;
    }else{
	return false;
    }
}