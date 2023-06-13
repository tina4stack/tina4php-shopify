<?php
use Shopify\Webhooks\Handler;

class GenericHandler implements Handler
{
    public function handle(string $topic, string $shop, array $requestBody): void
    {
        // Handle your webhook here!
        \Tina4\Debug::message($topic." for shop {$shop}", TINA4_LOG_ALERT);

        //switch statement to handle the web hooks!
        switch ($topic) {
            case Shopify\Webhooks\Topics::APP_UNINSTALLED:
                // Do something when the app is uninstalled
                (new ShopifyHelper())->removeShop($shop);

            break;
            case Shopify\Webhooks\Topics::CARTS_CREATE:
                // Do something when a cart is created
                \Tina4\Debug::message("Cart created for shop {$shop}", TINA4_LOG_ALERT);
            break;

        }

    }
}