<?php
use Shopify\Webhooks\Registry;
use Shopify\Webhooks\Topics;

class ShopifyHelper
{
    private array $REGISTERED_HANDLERS = [Shopify\Webhooks\Topics::APP_UNINSTALLED, Shopify\Webhooks\Topics::CARTS_CREATE, Shopify\Webhooks\Topics::CARTS_UPDATE, Shopify\Webhooks\Topics::ORDERS_CREATE, Shopify\Webhooks\Topics::ORDERS_UPDATED, Shopify\Webhooks\Topics::ORDERS_CANCELLED];

    /**
     * This is where we add all the handlers for the webhooks we want to listen to.
     * @return void
     */
    function addHandlers(): void
    {
        foreach ($this->REGISTERED_HANDLERS as $handler) {
            Registry::addHandler($handler, new GenericHandler());
        }
    }

    /**
     * Register handlers
     * @param $shop
     * @param $accessToken
     * @return void
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Shopify\Exception\InvalidArgumentException
     * @throws \Shopify\Exception\UninitializedContextException
     * @throws \Shopify\Exception\WebhookRegistrationException
     */
    function registerHandlers($shop, $accessToken): void
    {
        foreach ($this->REGISTERED_HANDLERS as $handler) {
            $response = Shopify\Webhooks\Registry::register(
                '/shopify/webhooks',
                $handler,
                $shop,
                $accessToken
            );

            if ($response->isSuccess()) {
                // Webhook registered!
                \Tina4\Debug::message("Webhook registration succeeded for:".$handler , TINA4_LOG_ALERT);
            } else {
                \Tina4\Debug::message("Webhook registration failed with response: \n" . var_export($response, true), TINA4_LOG_ERROR);
            }
        }
    }

    /**
     * Gets the session data needed for the twig template
     * @param $request
     * @return array
     * @throws ReflectionException
     */
    function getSessionData($request) : array
    {
        if (!isset($request->params["shop"])) {
            return [];
        }

        //Fetch the session data from the database
        $sessionData = (new Session())->select("*")->where("shop = ?", [$request->params["shop"]])->asArray();

        if (empty($sessionData)) {
            return [];
        }

        $accessToken = json_decode($sessionData[0]["sessionData"]);

        return ["accessToken" => $accessToken, "env" => $_ENV];
    }

    /**
     * Removes store session and cookie
     * @param string $shop
     * @return bool
     * @throws Exception
     */
    public function removeShop(string $shop): bool
    {
        (new Session())->delete("shop = ?", [$shop]);
        (new Cookie())->delete("shop = ?", [$shop]);
        return true;
    }
}