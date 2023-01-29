<?php

require_once realpath(dirname(__DIR__) . '/Core/Route.php');


return [
  new Route('/hello/text?:var', 'hello', 'text'),
  new Route('/test/hello/:var', 'test', 'hello'),
];