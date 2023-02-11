<?php

require_once realpath(dirname(__DIR__) . '/Core/Route.php');

return [
  new Route('/admin/login-form/', 'admin', 'loginForm'),
  new Route('/admin/login/', 'admin', 'login'),
  new Route('/admin/register/', 'admin', 'register'),
  new Route('/admin/register-form/', 'admin', 'registerForm'),
  new Route('/admin/', 'admin', 'default'),
];