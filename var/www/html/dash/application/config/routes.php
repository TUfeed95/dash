<?php

require_once realpath(dirname(__DIR__) . '/Core/Route.php');

return [
  new Route('/hello/text?var=str', 'hello', 'text'),
];
