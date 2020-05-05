<?php

declare(strict_types=1);

namespace Spacetab\DbConfig;

final class Reader
{
    private const DEFAULT_CONN_TYPE = 'default';
    private const DEFAULT_DB_TYPE   = 'pgsql';

    /**
     * @var array<string, array<string, mixed>>
     */
    private array $items;

    /**
     * @var array<string, callable>
     */
    private array $packers;

    /**
     * Reader constructor.
     *
     * @param array<string, array<string, mixed>> $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param string $typeName
     * @param \Spacetab\DbConfig\Packer\PackerInterface|callable $packer
     */
    public function addPacker(string $typeName, callable $packer): void
    {
        $this->packers[$typeName] = $packer;
    }

    public function getConnectionString(string $connectionName = self::DEFAULT_CONN_TYPE): string
    {
        if (count($this->items) > 0 && !array_key_exists($connectionName, $this->items)) {
            throw new \InvalidArgumentException("Database connection name `{$connectionName}` not found.");
        }

        $config = count($this->items) > 0 ? $this->items[$connectionName] : null;
        $type = $config['type'] ?? self::DEFAULT_DB_TYPE;

        return $this->packers[$type]($connectionName, $config);
    }
}
