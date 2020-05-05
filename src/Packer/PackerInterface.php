<?php

declare(strict_types=1);

namespace Spacetab\DbConfig\Packer;

interface PackerInterface
{
    /**
     * @param string $connectionName
     * @param array<string, mixed>|null $config
     * @return string
     */
    public function __invoke(string $connectionName, ?array $config = null): string;
}
