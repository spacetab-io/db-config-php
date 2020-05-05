DB Config 
=========

[![CircleCI](https://circleci.com/gh/spacetab-io/db-config-php/tree/master.svg?style=svg)](https://circleci.com/gh/spacetab-io/db-config-php/tree/master)
[![codecov](https://codecov.io/gh/spacetab-io/db-config-php/branch/master/graph/badge.svg)](https://codecov.io/gh/spacetab-io/db-config-php)

Creates a DSN string from an array. Supports Connection URI's and Connection Key-Value strings.

## Installation

```bash
composer require spacetab-io/db-config
```

## Spec

```yaml
db:
  default: # <-- connection name
    type: pgsql
    name: string
    host: string|array
    port: int|array
    pass: string
    schema: string
    options: array<string, mixed>
  mysql: # <-- connection name
    type: mysql
    name: string
    host: string|array
    port: int|array
    pass: string
    options: array<string, mixed> 
```

Note: all parameters are optional. By default, used `default` connection and `pgsql` database type (`postgres@127.0.0.1:5432/postgres`). 

## Sample

```php
<?php

use Spacetab\DbConfig\Packer\KeyValue;
use Spacetab\DbConfig\Reader;

$config = new Reader([
    'default' => [
        'type' => 'pgsql',
        'name' => 'roquie',
        'host' => ['127.0.0.1', '127.0.0.2'],
        'port' => [5432, 6432],
        'user' => 'roquie',
        'pass' => 'secret',
        'schema' => 'public',
        'options' => [
            'connect_timeout' => 10,
            'target_session_attrs' => 'any',
            'sslmode' => 'require',
        ],
    ]
]);

$config->addPacker('pgsql', new KeyValue\Postgres());
$config->getConnectionString($connectionName = 'default'); 
# host=127.0.0.1,127.0.0.2 port=5432,6432 user=roquie password=secret dbname=roquie schema=roquie connect_timeout=10 target_session_attrs=any sslmode=require
```

Note: Amphp connection string to mysql and postgres clients does not support multiple hosts connection (05-05-2020).

## Depends

* \>= PHP 7.4
* Composer for install package

## License

The MIT License

Copyright © 2020 spacetab.io, Inc. https://spacetab.io

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

