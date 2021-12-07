<?php
/*
*	TATDIG API use example with php and curl
*	copyright TATDIG
*/

define('API_KEY','NZykTlrU3tcC1pn5'); //change this to your API key
define('HOSTNAME','arama.nigez.com'); //change this for your domain

function get_tatdig_results($apikey,$num,$page,$q,$host){

//sunucu adresi
$url = 'https://www.nigez.com/api_service.php';
// sunucuya aktarım için alanların hazırlanması
$fields = array(
            'apikey'=>urlencode($apikey),
            'num'=>urlencode($num),
            'page'=>urlencode($page),
            'q'=>urlencode($q),
            'host'=>urlencode(HOSTNAME)
);

//verileri uygun bir formata dönüştürmek
$fields_string = '';
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
$fields_string = rtrim($fields_string,'&');

//açık bağlantı
$ch = curl_init();

//özelleştirme curl
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//istek gönder sonuç al
$result = curl_exec($ch);

//hata ayıklama yazdırma

return $result;
}
