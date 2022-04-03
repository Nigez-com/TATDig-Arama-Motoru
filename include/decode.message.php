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

Bitcoin::setNetwork(NetworkFactory::tdcoin());
$addrCreator = new AddressCreator();

$address = 'TJ93r5iixbpeA9PkXhwptirTUkjGRt6NYt';

$sig = '-----BEGIN BITCOIN SIGNED MESSAGE-----
hi
-----BEGIN SIGNATURE-----
IE58e5SCP6vJd5Ypy2aG1OZmE6UjkOsxple2LusBu3UIIv8TTvY0JiJ3wKL4/DPG4L2QptB67b/j/Bx9zBtx1Bs=
-----END BITCOIN SIGNED MESSAGE-----';

/** @var PayToPubKeyHashAddress $address */
$address = $addrCreator->fromString($address);

/** @var CompactSignatureSerializerInterface $compactSigSerializer */
$compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
$serializer = new SignedMessageSerializer($compactSigSerializer);

$signedMessage = $serializer->parse($sig);
$signer = new MessageSigner();
if ($signer->verify($signedMessage, $address, Bitcoin::getNetwork())) {
    echo "Signature verified!\n";
} else {
    echo "Failed to verify signature!\n";
}
