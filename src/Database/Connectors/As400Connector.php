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
    protected function getDsn(array $config): string
    {
        $dsn = 'odbc:DRIVER={IBM i ACCESS ODBC Driver};NAM=0;';

        if (!empty($config['host'])) {
            $dsn .= "SYSTEM=${config['host']};";
        }
        if (!empty($config['port'])) {
            $dsn .= "PORT=${config['port']};";
        }
        if (!empty($config['database'])) {
            $dsn .= "DATABASE=${config['database']};";
        }
        if (!empty($config['username'])) {
            $dsn .= "UID=${config['username']};";
        }
        if (!empty($config['password'])) {
            $dsn .= "PWD=${config['password']};";
        }

        return $dsn;
    }
}
