<?php

declare(strict_types=1);

namespace Spacetab\Tests\DbConfig;

use PHPUnit\Framework\TestCase;
use Spacetab\DbConfig\Reader;
use Spacetab\DbConfig\Packer\KeyValue;

class ReaderTest extends TestCase
{
    public function testBehaviorWithEmptyOptions()
    {
        $reader = new Reader();
        $reader->addPacker('pgsql', function () {
            return 'default_connection_string';
        });

        $this->assertSame('default_connection_string', $reader->getConnectionString());
    }

    public function testUnusedConnectionName()
    {
        $reader = new Reader([
            'connectionName' => [
                //
            ]
        ]);

        $reader->addPacker('pgsql', function () {
            return 'default_connection_string';
        });

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Database connection name `default` not found.');

        $reader->getConnectionString();
    }

    public function testWhereItReturnsConnectionStringIfPackerExistsButOptionsNot()
    {
        $reader = new Reader();
        $reader->addPacker('pgsql', new KeyValue\Amp\Postgres());

        $this->assertSame('host=127.0.0.1 port=5432 user=postgres db=postgres', $reader->getConnectionString());
    }

    public function testWhereItReturnsConnectionStringIfPackerExistsWithOptions()
    {
        $reader = new Reader([
            'default' => [
                'type' => 'pgsql',
            ]
        ]);
        $reader->addPacker('pgsql', new KeyValue\Amp\Postgres());

        $this->assertSame('host=127.0.0.1 port=5432 user=postgres db=postgres', $reader->getConnectionString());
    }
}
