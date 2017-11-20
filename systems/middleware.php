<?php

use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;

$_auth = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    $getRoute = $request->getAttribute('route');
    if (!empty($getRoute) && isset($_SESSION['user']['id']) && !empty($_SESSION['user']['m_roles_id'])) {

        if (isset($_SESSION['user']['id']) && $_SESSION['user']['m_roles_id'] == true) {
            $response = $next($request, $response);
        }
    } else {
        $response->withStatus(403);
        $response->getBody()->write('<center><h1>Mohon maaf, anda tidak memiliki akses</h1></center>');
    }

    return $response;
};
if (getenv('ONLY_BACKEND') == 'true') {
    $app->add(function ($request, $response, $next) {
        /**
         * Get route name
         */
        $route = $request->getAttribute('route');

        $routeName = '';
        if ($route !== null) {
            $routeName = $route->getName();
        }
        /**
         * Set Global route
         */
        $publicRoutesArray = array(
            'login',
            'session',
            'logout',
        );
        /**
         * Check session
         */
        if ((!isset($_SESSION['user']['id']) || !isset($_SESSION['user']['m_roles_id']) || !isset($_SESSION['user']['akses'])) && !in_array($routeName, $publicRoutesArray)) {
            return unauthorizedResponse($response, ['Mohon maaf, anda tidak mempunyai akses']);
        }
        /**
         * Return if isset session
         */
        return $next($request, $response);
    });
}