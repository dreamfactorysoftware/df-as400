<?php

namespace DreamFactory\Core\As400\Database\Connectors;

use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class As400Connector extends Connector implements ConnectorInterface
{
    /**
     * Establish a database connection.
     *
     * @param  array $config
     * @return \PDO
     * @throws \Exception
     */
    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);
        $options = $this->getOptions($config);

        return $this->createConnection($dsn, $config, $options);
    }

    /**
     * Create a DSN string from a configuration.
     *
     * @param  array $config
     * @return string
     */
    protected function getDsn(array $config)
    {
        $dsnParts = [
            'odbc:DRIVER=%s',
            'System=%s',
            'Database=%s',
            'UserID=%s',
            'Password=%s',
        ];

        $dsnConfig = [
            $config['driverName'],
            $config['host'],
            $config['database'],
            $config['username'],
            $config['password'],
        ];

        if (array_key_exists('odbc_keywords', $config)) {
            $odbcKeywords = $config['odbc_keywords'];
            $parts = array_map(function($part) {
                return $part . '=%s';
            }, array_keys($odbcKeywords));
            $config = array_values($odbcKeywords);

            $dsnParts = array_merge($dsnParts, $parts);
            $dsnConfig = array_merge($dsnConfig, $config);
        }

        return sprintf(implode(';', $dsnParts), ...$dsnConfig);
    }
}
