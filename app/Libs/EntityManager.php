<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$isDevMode = true;
$proxyDir = null;
$cache = null;

$ORMconfig = ORMSetup::createAnnotationMetadataConfiguration(
    array(__DIR__."/../Entity"),
    $isDevMode,
    $proxyDir,
    $cache
);

$params = array(
    'driver' => 'pdo_mysql',
    'host' => $_ENV['DB_HOST'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'dbname' => $_ENV['DB_NAME'],
);


$entityManager = EntityManager::create($params, $ORMconfig);
$conn = $entityManager->getConnection();
$conn->getConfiguration()->setSchemaAssetsFilter(static function ($assetName) {
    return preg_match("~^(tray_)~", $assetName);
});

return $entityManager;
