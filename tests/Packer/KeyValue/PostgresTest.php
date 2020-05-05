<?php

declare(strict_types=1);

namespace Spacetab\Tests\DbConfig\Packer\KeyValue;

use PHPUnit\Framework\TestCase;
use Spacetab\DbConfig\Packer\KeyValue;

class PostgresTest extends TestCase
{
    public function testPackerReturnsDefaultConnStringIfConfigIsNull()
    {
        $packer = new KeyValue\Postgres();
        $string = $packer('default', null);

        $this->assertSame('host=127.0.0.1 port=5432 user=postgres dbname=postgres', $string);
    }

    public function invalidValuesProvider()
    {
        return [
            [['name' => 123]],
            [['user' => 123]],
            [['pass' => 123]],
            [['host' => 123]],
            [['host' => [0, 1]]],
            [['port' => 'asd']],
            [['port' => ['foo', 'bar']]],
            [['schema' => 1]],
            [['options' => 1]],
            [['options' => 'string']],
        ];
    }

    /**
     * @dataProvider invalidValuesProvider
     * @param array $values
     */
    public function testPackerThrowsAnExceptionIfProvidedInvalidValues(array $values)
    {
        $packer = new KeyValue\Postgres();

        $this->expectException(\InvalidArgumentException::class);

        $packer('default', $values);
    }

    public function testMultiServerConfiguration()
    {
        $packer = new KeyValue\Postgres();
        $string = $packer('default', [
            'host' => ['127.0.0.1', '127.0.0.2'],
            'port' => [5432, 6432],
            'user' => 'roquie',
            'pass' => 'secret',
            'schema' => 'custom',
            'options' => [
                'sslmode' => 'require',
                'connect_timeout' => 10,
            ],
        ]);

        $valid = 'host=127.0.0.1,127.0.0.2 port=5432,6432 user=roquie dbname=postgres password=secret schema=postgres sslmode=require connect_timeout=10';
        $this->assertSame($valid, $string);
    }
}
