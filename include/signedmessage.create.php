<?php

require __DIR__ . "/vendor/autoload.php";

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\Network\NetworkFactory;

Bitcoin::setNetwork(NetworkFactory::tdcoin());
$ec = Bitcoin::getEcAdapter();
//$random = new Random();
$privKeyFactory = new PrivateKeyFactory($ec);
$privateKey = $privKeyFactory->fromWif("GtgYQNFddYNSsouMywF227aqqHnhSy5xJmnphLswTF7wBHPRQqhK");

$message = 'hi';

$signer = new MessageSigner($ec);
$signed = $signer->sign($message, $privateKey);
$address = new PayToPubKeyHashAddress($privateKey->getPublicKey()->getPubKeyHash());
//echo $privateKey->getBuffer()->getBinary();
echo sprintf("Signed by %s\n%s\n", $address->getAddress(), $signed->getBuffer()->getBinary());

//	IE58e5SCP6vJd5Ypy2aG1OZmE6UjkOsxple2LusBu3UIIv8TTvY0JiJ3wKL4/DPG4L2QptB67b/j/Bx9zBtx1Bs=	Core
//	IE58e5SCP6vJd5Ypy2aG1OZmE6UjkOsxple2LusBu3UIIv8TTvY0JiJ3wKL4/DPG4L2QptB67b/j/Bx9zBtx1Bs=	PHP

/*
Bitcoin::setNetwork(NetworkFactory::bitcoin());
$ec = Bitcoin::getEcAdapter();
//$random = new Random();
$privKeyFactory = new PrivateKeyFactory($ec);
$privateKey = $privKeyFactory->fromWif("5Kg1gnAjaLfKiwhhPpGS3QfRg2m6awQvaj98JCZBZQ5SuS2F15C");

$message = 'hi';

$signer = new MessageSigner($ec);
$signed = $signer->sign($message, $privateKey);
$address = new PayToPubKeyHashAddress($privateKey->getPublicKey()->getPubKeyHash());
//echo $privateKey->getBuffer()->getBinary();
echo sprintf("Signed by %s\n%s\n", $address->getAddress(), $signed->getBuffer()->getBinary());
*/

/*Bitcoin::setNetwork(NetworkFactory::dash());
$ec = Bitcoin::getEcAdapter();
//$random = new Random();
$privKeyFactory = new PrivateKeyFactory($ec);
$privateKey = $privKeyFactory->fromWif("XCPi8pSQ39sVPVFdy6a9KyGRPdMELLDnzEen7BQodWi3g2PDLE3i");

$message = 'hi';

$signer = new MessageSigner($ec);
$signed = $signer->sign($message, $privateKey);
$address = new PayToPubKeyHashAddress($privateKey->getPublicKey()->getPubKeyHash());
//echo $privateKey->getBuffer()->getBinary();
echo sprintf("Signed by %s\n%s\n", $address->getAddress(), $signed->getBuffer()->getBinary());
*/