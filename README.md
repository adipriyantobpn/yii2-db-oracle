Oracle DB Base Component
========================
Base library and foundation components for Oracle Database

Why Using this Package?
-----------------------

Not all developer has access to Oracle DB as SYSDBA role.

In the default `yii\db\oci\Schema`, the database connection must specify user which has access to `DBA_USERS` view.

Please refer to `findSchemaNames()` function in :
`https://github.com/yiisoft/yii2/blob/master/framework/db/oci/Schema.php`

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist adipriyantobpn/yii2-db-oracle "*"
```

or add

```
"adipriyantobpn/yii2-db-oracle": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, you can access Oracle DB by configure db component in your `config.php` like this:

```php
'components' => [
    'db' => [
        'class' => 'adipriyantobpn\db\oracle\Connection',
        'host' => 'localhost',
        'port' => 1522 // default: 1521
        'sid' => 'XE'
        'dateFormat' => 'DD-MON-RR' // default: 'YYYY-MM-DD HH24:MI:SS'
    ],
]
```

By using configuration format above, the connection class will be automatically build Oracle DSN by using this template:

```php
$this->dsn = "oci:dbname=(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST={$this->host})(PORT={$this->port})))(CONNECT_DATA=(SID={$this->sid})))"
```

But if you want to configure DSN with different format, you can omit host, port, and sid properties like this:


```php
'components' => [
    'db' => [
        'class' => 'adipriyantobpn\db\oracle\Connection',
        'dsn' => 'oci:dbname=//localhost:1521/XE',
        'dateFormat' => 'DD-MON-RR' // default: 'YYYY-MM-DD HH24:MI:SS'
    ],
]
```