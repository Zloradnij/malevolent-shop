# malevolentiae-shop
shop

chmod 755 -R runtime/

chmod 755 -R web/assets/

composer install

create database shop

create file config/db.php
````
return [
  'class' => 'yii\db\Connection',
  'dsn' => 'mysql:host=localhost;dbname=dbname',
  'username' => 'username',
  'password' => 'password',
  'charset' => 'utf8',
  // Schema cache options (for production environment)
  'enableSchemaCache' => true,
  'schemaCacheDuration' => 10,
  'schemaCache' => 'cache',
];

````

create file config/mailer.php
````
return [
    'class'         => 'yii\swiftmailer\Mailer',
    'transport'     => [
        'class'      => 'Swift_SmtpTransport',
        'host'       => 'smtp.gmail.com',
        'username'   => 'my@mail.com',
        'password'   => 'myMailPassword',
        'port'       => '587', // Port 25 is a very common port too
        'encryption' => 'tls', // It is often used, check your provider or mail server specs
    ],
    'messageConfig' => [
        'from'    => ['my@mail.com' => 'I am admin'], // this is needed for sending emails
        'charset' => 'UTF-8',
    ],
];

````

php yii migrate --migrationPath=@yii/rbac/migrations/

php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations

go to http://shop.domain.com/user/register

register now

confirmed register

php yii create-roles admin Admin

php yii create-roles user User

php yii create-roles manager Manager

php yii set-user-role 1 admin

set you domain in .htaccess