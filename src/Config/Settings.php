<?php

declare(strict_types=1);

namespace Hoop\Config;

use Hoop\Database\Database;

final class Settings
{
    private $settings;
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $settingsCollection = $database->findAll('site_settings');
        foreach ($settingsCollection as $setting) {
            $this->settings[$setting['name']] = $setting['value'];
        }
    }

    public function toArray(): array
    {
        return $this->settings;
    }

    public function updateSettings(array $settings)
    {
        foreach ($settings as $key => $val) {
            $this->database->update(
                'site_settings',
                ['value' => $val],
                ['name' => $key]
            );
        }
        $this->settings = $settings;
    }
}