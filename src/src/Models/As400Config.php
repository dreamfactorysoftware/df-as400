<?php

namespace DreamFactory\Core\As400\Models;

use DreamFactory\Core\SqlDb\Models\SqlDbConfig;

/**
 * As400 config
 */
class As400Config extends BaseServiceConfigModel
{
    public static function getDriverName()
    {
        return 'as400';
    }

    public static function getDefaultPort()
    {
        return 446;
    }

}
