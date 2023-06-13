<?php

\Tina4\Get::add ("/", function(\Tina4\Response $response, \Tina4\Request $request) {
    if (isset($request->server["HTTP_REFERER"]) && $request->server["HTTP_REFERER"] === "https://partners.shopify.com/") {
        $url = \Shopify\Auth\OAuth::begin($request->params["shop"], "/auth/callback", "0", function (Shopify\Auth\OAuthCookie $cookie) use ($request) {
            $cookieData = new Cookie();
            $cookieData->name = $cookie->getName();
            $cookieData->value = $cookie->getValue();
            $cookieData->shop = $request->params["shop"];
            $cookieData->expires = $cookie->getExpire();
            $cookieData->save();
            setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpire());
            return true;
        });

        \Tina4\redirect($url);
    }

    if (!isset($request->params["shop"])) {
        return $response("No access", HTTP_FORBIDDEN);
    }

    return $response(\Tina4\renderTemplate("admin.twig", array_merge(["pageName" => "Home"], (new ShopifyHelper())->getSessionData($request))));
});

\Tina4\Get::add ("/settings", function(\Tina4\Response $response, \Tina4\Request $request) {
    if (!isset($request->params["shop"])) {
        return $response("No access", HTTP_FORBIDDEN);
    }

    return $response(\Tina4\renderTemplate("admin.twig", array_merge(["pageName" => "Settings"], (new ShopifyHelper())->getSessionData($request))));
});