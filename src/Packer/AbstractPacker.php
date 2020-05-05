<?php

declare(strict_types=1);

namespace Spacetab\DbConfig\Packer;

abstract class AbstractPacker implements PackerInterface
{

    /**
     * @param string $connectionName
     * @param array<string, mixed> $config
     * @return array<string>
     */
    protected function validateHosts(string $connectionName, array $config): array
    {
        if (!is_string($config['host']) && !is_array($config['host'])) {
            throw new \InvalidArgumentException(
                "Conn `{$connectionName}`. Database host should be as string or array type."
            );
        }

        $hosts = (array) $config['host'];

        foreach ($hosts as $host) {
            if (!is_string($host)) {
                throw new \InvalidArgumentException(
                    "Conn `{$connectionName}`. Database host should be as string."
                );
            }
        }

        return $hosts;
    }

    /**
     * @param string $connectionName
     * @param array<string, mixed> $config
     * @return array<int>
     */
    protected function validatePorts(string $connectionName, array $config): array
    {
        if (!is_int($config['port']) && !is_array($config['port'])) {
            throw new \InvalidArgumentException(
                "Conn `{$connectionName}`. Database port for should be as integer or array type."
            );
        }

        $ports = (array) $config['port'];

        foreach ($ports as $port) {
            if (!is_int($port)) {
                throw new \InvalidArgumentException(
                    "Conn `{$connectionName}`. Database port should be as integer type."
                );
            }
        }

        return $ports;
    }

    /**
     * @param string $connectionName
     * @param array<string, mixed> $config
     * @return array<string, mixed>
     */
    protected function validateOptions(string $connectionName, array $config): array
    {
        $options = $config['options'];

        if (!is_array($options)) {
            throw new \InvalidArgumentException(
                "Conn `{$connectionName}`. Database options should be as array type."
            );
        }

        return $options;
    }

    /**
     * @param string $connectionName
     * @param array<string, mixed> $config
     * @return string
     */
    protected function validateName(string $connectionName, array $config): string
    {
        return $this->validateString(
            $config['name'], "Conn `{$connectionName}`. Database name should be as string type."
        );
    }

    /**
     * @param string $connectionName
     * @param array<string, mixed> $config
     * @return string
     */
    protected function validatePass(string $connectionName, array $config): string
    {
        return $this->validateString(
            $config['pass'], "Conn `{$connectionName}`. Database pass should be as string type."
        );
    }

    /**
     * @param string $connectionName
     * @param array<string, mixed> $config
     * @return string
     */
    protected function validateUser(string $connectionName, array $config): string
    {
        return $this->validateString(
            $config['user'], "Conn `{$connectionName}`. Database user should be as string type."
        );
    }

    /**
     * @param mixed $value
     * @param string $message
     * @return string
     */
    protected function validateString($value, string $message): string
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException($message);
        }

        return $value;
    }
}
