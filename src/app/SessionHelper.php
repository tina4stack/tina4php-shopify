<?php

class SessionHelper extends \Tina4\Data implements \Shopify\Auth\SessionStorage
{

    /**
     * Stores the session the database
     */
    public function storeSession(\Shopify\Auth\Session $session): bool
    {
        // TODO: Implement storeSession() method.
        $sessionData = (new Session());
        //file_put_contents("./sessions/{$session->getId()}", serialize($session));
        $sessionData->sessionId = $session->getId();
        $sessionData->shop = $session->getShop();
        $sessionJson = json_encode(["id" => $session->getId(), "shop" => $session->getShop(), "isOnline" => $session->isOnline(), "state" => $session->getState(), "accessToken" => $session->getAccessToken(), "expires" => $session->getExpires()]);
        $sessionData->sessionData = $sessionJson;
        $sessionData->save();

        return true;

    }

    /**
     * Loads the session for Shopify from the database
     * @param string $sessionId
     * @return mixed|\Shopify\Auth\Session|null
     */
    public function loadSession(string $sessionId)
    {
        // TODO: Implement loadSession() method.
        $sessionData = new Session();
        if ($sessionData->load("session_id = ?", [$sessionId])) {
            $sessionJson = json_decode($sessionData->sessionData);

            $session = new \Shopify\Auth\Session($sessionJson->id, $sessionJson->shop, $sessionJson->isOnline, $sessionJson->state);
            return $session;
        }

        //if (file_exists("./sessions/{$sessionId}")) {
        //    return unserialize(file_get_contents("./sessions/{$sessionId}"));
        //}

        return null;
    }

    /**
     * Deletes the session from the database
     * @param string $sessionId
     * @return bool
     */
    public function deleteSession(string $sessionId): bool
    {
        unlink("./sessions/{$sessionId}");
        return true;
    }

    /**
     * Gets cookies for a particular shop
     * @param $shop
     * @return array
     * @throws ReflectionException
     */

    public function getCookieData(string $shop): array
    {
        $cookies = (new Cookie())->select("*")->where("shop = ?", [$shop])->asArray();

        $result = [];
        foreach ($cookies as $cookie) {
            $result[$cookie["name"]] = $cookie["value"];
        }

        return $result;
    }
}