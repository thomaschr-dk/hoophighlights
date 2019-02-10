<?php

declare(strict_types=1);

namespace Hoop\Database;

use Doctrine\DBAL\Schema\Schema;
use Hoop\Database\DoctrineDbalDatabase as Connection;
use Hoop\Config\Settings;

final class DbalInstaller
{
    private $connection;
    private $schema;
    private $scripts = [];
    private $configSettings = [];

    public function __construct(Connection $connection, Schema $schema, Settings $configSettings)
    {
        $this->connection = $connection;
        $this->schema = $schema;
        $this->configSettings = $configSettings;
    }

    public function installScripts()
    {
        $configSettings = $this->configSettings->toArray();
        $siteVersion = $configSettings['site_version'];
        $iterator = new \DirectoryIterator(__DIR__ . '/sql');
        foreach ($iterator as $file) {
            $fileVersion = str_replace('.php', '', $file->getFilename());
            if ($file->isDot() || $file->getExtension() != 'php' || $siteVersion >= $fileVersion) {
                continue;
            }
            $this->installScript(include $file->getPath() . '/' . $file->getFilename(), $fileVersion);
        }
    }

    public function installScript(array $scripts, string $version)
    {
        foreach ($scripts as $script) {
            if (in_array($script['table_name'], $this->scripts)) {
                continue;
            }

            $newTable = $this->schema->createTable($script['table_name']);
            foreach ($script['columns'] as $column_id => $column) {
                if (!array_key_exists('options', $column)) {
                    $column['options'] = [];
                }

                $newTable->addColumn(
                    $column_id,
                    $column['type'],
                    $column['options']
                );
            }

            if (array_key_exists('primary_key', $script)) {
                $newTable->setPrimaryKey($script['primary_key']);
            }

            if (array_key_exists('foreign_keys', $script)) {
                foreach ($script['foreign_keys'] as $foreign_key) {
                    $newTable->addForeignKeyConstraint(
                        $foreign_key['foreign_table'],
                        $foreign_key['table_columns'],
                        $foreign_key['foreign_columns'],
                        $foreign_key['options']
                    );
                }
            }
        }

        $connection = $this->connection->getConnection();
        $platform = $connection->getDatabasePlatform();
        $queries = $this->schema->toSql($platform);

        foreach ($queries as $query) {
            $connection->executeQuery($query);
        }

        $configSettings = $this->configSettings->toArray();
        $configSettings['site_version'] = $version;
        $this->configSettings->updateSettings($configSettings);
    }
}