<?php

use Framework\RouteDefinition;

return [
    new RouteDefinition(['GET'], '/', [\Modules\Main\Controller::class, 'home']),
    new RouteDefinition(['GET'], '/token', [\Modules\Main\Controller::class, 'token']),
    new RouteDefinition(['GET'], '/exception', [\Modules\Main\Controller::class, 'exception']),
    new RouteDefinition(['GET'], '/view', [\Modules\Main\Controller::class, 'view']),
    new RouteDefinition(['POST'], '/fileUpload', [\Modules\Main\Controller::class, 'fileUpload']),
    new RouteDefinition(['GET'], '/cookie', [\Modules\Main\Controller::class, 'cookie']),
    new RouteDefinition(['GET'], '/cry', [\Modules\Main\Controller::class, 'encryption']),
    new RouteDefinition(['GET'], '/sess', [\Modules\Main\Controller::class, 'session']),
];
