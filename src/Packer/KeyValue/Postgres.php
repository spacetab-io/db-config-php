<?php

declare(strict_types=1);

namespace Spacetab\DbConfig\Packer\KeyValue;

use Spacetab\DbConfig\Packer\AbstractPacker;

final class Postgres extends AbstractPacker
{
    /**
     * https://www.postgresql.org/docs/12/libpq-connect.html#LIBPQ-CONNSTRING
     *
     * @param string $connectionName
     * @param array<string, mixed>|null $config
     * @return string
     */
    public function __invoke(string $connectionName, ?array $config = null): string
    {
        if (is_null($config)) {
            return 'host=127.0.0.1 port=5432 user=postgres dbname=postgres';
        }

        $name    = isset($config['name'])    ? $this->validateName($connectionName, $config)    : 'postgres';
        $user    = isset($config['user'])    ? $this->validateUser($connectionName, $config)    : 'postgres';
        $pass    = isset($config['pass'])    ? $this->validatePass($connectionName, $config)    : null;
        $hosts   = isset($config['host'])    ? $this->validateHosts($connectionName, $config)   : ['127.0.0.1'];
        $ports   = isset($config['port'])    ? $this->validatePorts($connectionName, $config)   : [5432];
        $schema  = isset($config['schema'])  ? $this->validateSchema($connectionName, $config)  : null;
        $options = isset($config['options']) ? $this->validateOptions($connectionName, $config) : [];

        $chunks = [
            'host='   . join(',', $hosts),
            'port='   . join(',', $ports),
            'user='   . $user,
            'dbname=' . $name
        ];

        if (!is_null($pass)) {
            $chunks[] = 'password=' . $pass;
        }

        if (!is_null($schema)) {
            $chunks[] = 'schema=' . $name;
        }

        foreach ($options as $key => $value) {
            $chunks[] = "{$key}={$value}";
        }

        return join(' ', $chunks);
    }

    /**
     * @param string $connectionName
     * @param array<string, mixed> $config
     * @return string
     */
    protected function validateSchema(string $connectionName, array $config): string
    {
        return $this->validateString(
            $config['schema'], "Conn `{$connectionName}`. Database schema should be as string type."
        );
    }
}
