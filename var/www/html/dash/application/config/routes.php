<?php

require_once realpath(dirname(__DIR__) . '/Core/Route.php');

return [
  new Route('/hello/text?var=str', 'hello', 'text'),
  new Route('/admin/login/', 'admin', 'login'),
  new Route('/admin/login-form/', 'admin', 'loginForm')
];
