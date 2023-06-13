<?php
require_once "./vendor/autoload.php";
\Tina4\Initialize();

//Database connection for sessions, default is SQLite3, but you can change it if you like.
global $DBA;
$DBA = new \Tina4\DataSQLite3("sessions.db");


$config = new \Tina4\Config(function(\Tina4\Config $config) {

    \Shopify\Context::initialize(
        $_ENV['SHOPIFY_API_KEY'],
        $_ENV['SHOPIFY_API_SECRET'],
        $_ENV['SHOPIFY_APP_SCOPES'],
        $_ENV['SHOPIFY_APP_HOST_NAME'],
        new \SessionHelper(),
        \Shopify\ApiVersion::LATEST,
        true,
        false);

    //Add the handlers to listen to the webhooks
    (new ShopifyHelper())->addHandlers();

});

$config->setAuth(new AuthHelper());

echo new \Tina4\Tina4Php($config);