<?php

use Framework\RouteDefinition;

return [
    new RouteDefinition(['GET'], '/', [\Modules\Main\Controller::class, 'home']),
];
