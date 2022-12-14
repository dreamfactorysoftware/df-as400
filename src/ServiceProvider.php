<?php
namespace DreamFactory\Core\As400;

use DreamFactory\Core\Components\DbSchemaExtensions;
use DreamFactory\Core\Services\ServiceManager;
use DreamFactory\Core\Services\ServiceType;
use DreamFactory\Core\Enums\ServiceTypeGroups;
use DreamFactory\Core\Enums\LicenseLevel;
use DreamFactory\Core\As400\Services\As400;
use DreamFactory\Core\As400\Models\As400Config;
use DreamFactory\Core\As400\Database\Connectors\As400Connector;
use DreamFactory\Core\As400\Database\As400Connection;
use DreamFactory\Core\As400\Database\Schema\As400Schema;
use Illuminate\Database\DatabaseManager;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        // Add our database drivers
        $this->app->resolving('db', function (DatabaseManager $db) {
            $db->extend('as400', function ($config) {
                $connector = new As400Connector();
                $connection = $connector->connect($config);

                return new As400Connection($connection, $config["database"], $config["prefix"], $config);
            });
        });

        // Add our service types.
        $this->app->resolving('df.service', function (ServiceManager $df) {
            $df->addType(
                new ServiceType([
                    'name'            => 'as400',
                    'label'           => 'AS400',
                    'description'     => 'Database service for supporting AS400 database connector',
                    'group'           => ServiceTypeGroups::DATABASE,
                    'subscription_required' => LicenseLevel::SILVER, 
                    'config_handler'  => As400Config::class,
                    'factory'         => function ($config) {
                        return new As400($config);
                    },
                ])
            );
        });

        // Add our database extensions
        $this->app->resolving('db.schema', function (DbSchemaExtensions $db) {
            $db->extend('as400', function ($connection) {
                return new As400Schema($connection);
            });
        });
    }
}
