<?php
try {
	$user = new User();
} catch (Exception $e) {
  throw new Exception($e);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/assets/css/custom.css"/>
  <link rel="stylesheet" href="/assets/css/main/app.css"/>
  <link rel="stylesheet" href="/assets/css/main/app-dark.css"/>
  <link rel="shortcut icon" href="/assets/images/logo/favicon.svg" type="image/x-icon"/>
  <link rel="shortcut icon" href="/assets/images/logo/favicon.png" type="image/png"/>
  <link rel="stylesheet" href="/assets/css/shared/iconly.css"/>
  <link rel="stylesheet" href="/assets/extensions/toastify-js/src/toastify.css">
</head>

<body>
<div id="app">
  <div id="main" class="layout-horizontal">
    <header class="mb-5">
      <nav class="navbar navbar-expand navbar-light navbar-top header-top">
        <div class="container">

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a href="#" class="custom-burger burger-btn d-block d-xl-none">
              <i class="bi bi-justify fs-3"></i>
            </a>
            <div class="logo">
              <a href="/admin/"><img src="/assets/images/logo/logo.svg" alt="Logo"/></a>
            </div>

            <ul class="navbar-nav ms-auto mb-lg-0">
              <li class="nav-item dropdown me-1">
                <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-envelope bi-sub fs-4"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li>
                    <h6 class="dropdown-header">Письма</h6>
                  </li>
                  <li>
                    <p class="text-center py-2 mb-0">
                      Нет новых писем
                    </p>
                  </li>
                </ul>
              </li>
              <li class="nav-item dropdown me-3">
                <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                  <i class="bi bi-bell bi-sub fs-4"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="dropdownMenuButton">
                  <li>
                    <h6 class="dropdown-header">Уведомления</h6>
                  </li>

                  <li>
                    <p class="text-center py-2 mb-0">
                      <a href="#">Все уведомления</a>
                    </p>
                  </li>
                </ul>
              </li>
            </ul>
            <div class="dropdown">
              <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-menu d-flex">
                  <div class="user-name text-end me-3">
                    <h6 class="mb-0 text-gray-600"><?php echo $user->login ?? ''?></h6>
                    <p class="mb-0 text-sm text-gray-600"><?php echo $user->email ?? ''?></p>
                  </div>
                  <div class="user-img d-flex align-items-center">
                    <div class="avatar avatar-md">
                      <img src="/assets/images/faces/1.jpg" alt="Avatar">
                    </div>
                  </div>
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                <li>
                  <h6 class="dropdown-header"><?php echo 'Привет, ' . $user->firstname ?? ''?></h6>
                </li>
                <li>
                  <a class="dropdown-item" href="/admin/user/profile/"><i class="icon-mid bi bi-person me-2"></i>Мой профиль</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>Настройки</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="/admin/logout/"><i class="icon-mid bi bi-box-arrow-left me-2"></i>Выход</a>
                </li>
              </ul>
            </div>
          </div>

        </div>

      </nav>

      <nav class="main-navbar">
        <div class="container">
          <ul>
            <li class="menu-item">
              <a href="/admin/" class="menu-link">
                <span>Главная</span>
              </a>
            </li>
            <li class="menu-item">
              <a href="" class="menu-link">
                <span>Задачи</span>
              </a>
            </li>
            <li class="menu-item">
              <a href="" class="menu-link">
                <span>Проекты</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>