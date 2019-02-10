<?php

use Hoop\Database\Database;
use Hoop\Database\DoctrineDbalDatabaseFactory;
use Doctrine\DBAL\Schema\Schema;
use Hoop\Templating\Template;
use Hoop\Templating\TemplateDirectory;
use Hoop\Templating\TwigTemplateFactory;
use Hoop\Routing\Router;
use Hoop\Routing\FastRouter;
use Hoop\Database\DbalInstaller;
use Hoop\Config\Settings as ConfigSettings;

return [
    Router::class => new FastRouter(
        include dirname(__DIR__) . '/config/routes.php'
    ),
    TemplateDirectory::class => new TemplateDirectory(
        dirname(__DIR__)
    ),
    ConfigSettings::class => DI\Create()->constructor(
        DI\Get(Database::class)
    ),
    Template::class => function(TwigTemplateFactory $c) {
        return $c->create();
    },
    DoctrineDbalDatabaseFactory::class => DI\Create()->constructor(
        include dirname(__DIR__) . '/config/database.php'
    ),
    Database::class => function(DoctrineDbalDatabaseFactory $c) {
        return $c->create();
    },
    Schema::class => new Schema(),
    DbalInstaller::class => DI\Create()->constructor(
        DI\Get(Database::class),
        DI\Get(Schema::class),
        DI\Get(ConfigSettings::class)
    )
];