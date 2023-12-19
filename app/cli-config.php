<?php

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use App\Libs\DI;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

$config = new PhpFile('migrations.php');
$DI = DI::Container();
$entityManager = $DI->get('EntityManager');

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
