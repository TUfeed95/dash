<?php

require_once realpath(dirname(__DIR__) . '/Core/Route.php');

return [
  new Route('/admin/login-form/', 'admin', 'authorizationData'),
  new Route('/admin/login/', 'admin', 'login'),
  new Route('/admin/register/', 'admin', 'register'),
  new Route('/admin/register-form/', 'admin', 'registrationData'),
  new Route('/admin/', 'admin', 'default'),
];