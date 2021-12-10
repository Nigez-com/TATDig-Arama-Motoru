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
<div id="content" class="vertical-center">
    <center>
        <form>
            <input id="search" name="search" type="search" value="<?php echo ( array_key_exists('search', $_GET) ? $_GET['search'] : "" ); ?>">
            <input type="submit" id="go" value="ileri!">
        </form>
<?php
    if( !array_key_exists('search',$_GET) || empty(trim($_GET['search'])) ){ ?>

<?php }else{
    require_once('include/TATDig_API.php');
    $results = get_tatdig_results(API_KEY,5,$page,trim($_GET['search']),HOSTNAME);

    $xml = new DOMDocument( "1.0", "utf-8" );
    $xml->loadXML($results);
    foreach ($xml->getElementsByTagName('result') as $result) {
	echo "<div class=\"result\">";
	echo "<a href=\"".$result->getAttribute('url')."\">".$result->getAttribute('title')."</a><br>";
	echo "<p>".$result->getElementsByTagName('descr')[0]->textContent."</p>";
	echo $result->getAttribute('title')."<br>";
	echo "</div> <!-- result --> <hr>"; 
    }
 } ?>

        <h1>TATDig arama motoru</h1>
    <p>Çağrı denetleyicisi burada olabilir</p>
    <p><a href="https://github.com/Nigez-com/TATDig-Arama-Motoru">Geliştirme kaynakları</a>
    </center>
</div>
</body>
</html>
