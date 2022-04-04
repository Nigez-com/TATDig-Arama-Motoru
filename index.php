<!doctype html>
<html lang="tr" dir="ltr">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="Turkic Search Engine" />
<meta property="og:description" content="Powered by TATDig API" />
<link rel="stylesheet" type="text/css" href="/css/style.css">
<title>Arama Motoru</title>
<script src="/js/functions.js"></script>
</head>
<body>
<div id="leftcol20" class="column"></div>
<div id="content" class="column">
    <center>
<div id="user" class="right">
<?php
    require_once('include/config.inc.php');
    require_once('include/users.php');
    $addr = get_user();

/*    if ( $addr === false ){ echo '<a href="/register.php">Register</a><a href="/signin.php">Signin</a>'; }
    else { echo "<a href=\"signout.php\" title=\"Signout\">$addr</a>"; } */

    if ( $addr === false ){ echo '<a href="javascript:reg_frm();"> Register </a><a href="javascript:signin_frm();"> Signin </a>'; }
    else { echo '<a href="javascript:signout();" title="Sign out">'.$addr.'</a>'; }

    function stypeHtml(){
        $html='';
        for( $i=0; $i< count(SEARCH_TYPES); $i++){
            $html =$html. '<option'.( array_key_exists('stype', $_GET)&&$_GET['stype']==$i ? ' selected=true' : "" ).' value="'.$i.'">'.SEARCH_TYPES[$i].'</option>'.PHP_EOL;
        }
        return $html;
    }

?></div><br><br>

        <form>
            <select id="stype" name="stype"><?php echo stypeHtml(); ?></select>
            <input id="search" name="search" type="search" value="<?php echo ( array_key_exists('search', $_GET) ? $_GET['search'] : "" ); ?>">
            <input type="submit" id="go" value="ileri!">
        </form>
<?php
    if( !array_key_exists('search',$_GET) || empty(trim($_GET['search'])) ){ ?>

<?php }else{
    require_once('include/TATDig_API.php');
    $results = get_tatdig_results(API_KEY,5,$page,trim($_GET['search']),HOSTNAME,$_GET['stype']);

    $xml = new DOMDocument( "1.0", "utf-8" );
    $xml->loadXML($results);$xml->save('xml/search.xml');
    foreach ($xml->getElementsByTagName('result') as $result) {
	echo "<div class=\"result\">";
	echo "<a href=\"".$result->getAttribute('url')."\">".$result->getAttribute('title')."</a><br>";
	echo "<p>".$result->getElementsByTagName('descr')[0]->textContent."</p>";
	if($_GET['stype']==1){
	    echo date('Y-m-d H:i:s',strtotime($result->getAttribute('publishedDate')))."<br>";
	    if(strpos($result->getAttribute('enclType'),'image')!== false)
		if(!empty($result->getAttribute('enclUrl'))) echo '<img src="'.$result->getAttribute('enclUrl').'">';
	}elseif($_GET['stype']==2){
	    if(strpos($result->getAttribute('enclType'),'image')!== false)
		if(!empty($result->getAttribute('enclUrl'))) echo '<img src="'.$result->getAttribute('enclUrl').'">';
	}elseif($_GET['stype']==3){
	    if(strpos($result->getAttribute('enclType'),'video')!== false)
		if(!empty($result->getAttribute('enclUrl'))) echo '<video controls><source src="'.$result->getAttribute('enclUrl').'"></video>'.PHP_EOL;
	}
	echo "</div> <!-- result --> <hr>"; 
    }
 } ?>
<br>Ve daha fazlası ...
        <h1>TATDig arama motoru</h1>
    <p>Çağrı denetleyicisi burada olabilir</p>
    <p><a href="https://github.com/Nigez-com/TATDig-Arama-Motoru">Geliştirme kaynakları</a><br>
    <a href="https://api.tatdig.org/examples/api_php_curl_example.txt" title="TATDig Turkic search engine">
        Powered By TATDig
    </a>

    </center>

</div>
<div id="rightcol20" class="column"></div>
</body>
</html>
