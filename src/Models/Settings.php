<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class Settings extends Model
{
    public array $implement = [\Igniter\System\Actions\SettingsModel::class];

    // A unique code used for saving the settings to the database
    public string $settingsCode = 'paolorox_restapro_settings';

    // Reference to form field model config file, without the .php extension. 
    public string $settingsFieldsConfig = 'settings';
}
