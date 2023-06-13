<?php

/**
 * @secure
 */
\Tina4\Post::add("/shopify/webhooks|api/webhooks", function(\Tina4\Response $response, \Tina4\Request $request) {
    \Tina4\Debug::message("Webhook fired ", TINA4_LOG_ALERT);
    try {
        $checkAuth = Shopify\Webhooks\Registry::process($request->headers, $request->rawRequest);

        if ($checkAuth->isSuccess()) {
            return $response ("OK", HTTP_OK, "text/plain");
        } else {
            // The webhook request was valid, but the handler threw an exception
            \Tina4\Debug::message("Webhook handler failed with message: " . $response->getErrorMessage(), TINA4_LOG_ERROR);
        }
    } catch (\Exception $error) {
        // The webhook request was not a valid one, likely a code error or it wasn't fired by Shopify
        \Tina4\Debug::message("WEBHOOK PROCESS ERROR:\n". print_r($error,1), TINA4_LOG_ERROR);
    }
});