<?php

\Tina4\Get::add ("/login", function(\Tina4\Response $response, \Tina4\Request $request) {
    $url = \Shopify\Auth\OAuth::begin($request->params["shop"], "/auth/callback", "0", function(Shopify\Auth\OAuthCookie $cookie) use ($request) {
        $cookieData = new Cookie();
        $cookieData->name = $cookie->getName();
        $cookieData->value = $cookie->getValue();
        $cookieData->shop = $request->params["shop"];
        $cookieData->expires = $cookie->getExpire();
        $cookieData->save();
        return true;
    } );
    \Tina4\redirect($url);
});


\Tina4\Get::add ("/auth/callback", function(\Tina4\Response $response, \Tina4\Request $request) {
    if (!isset($request->params["shop"])) {
        return $response("No access", HTTP_FORBIDDEN);
    }

    $cookieData = (new SessionHelper())->getCookieData($request->params["shop"]);

    $session = Shopify\Auth\OAuth::callback($cookieData, $request->params);

    (new SessionHelper())->storeSession($session);
    (new ShopifyHelper())->registerHandlers($session->getShop(), $session->getAccessToken());

    //redirect here to store
    \Tina4\redirect("https://{$request->params["shop"]}");
});

