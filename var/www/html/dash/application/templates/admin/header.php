<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/main/app.css"/>
  <link rel="stylesheet" href="../../assets/css/main/app-dark.css"/>
  <link rel="shortcut icon" href="../../assets/images/logo/favicon.svg" type="image/x-icon"/>
  <link rel="shortcut icon" href="../../assets/images/logo/favicon.png" type="image/png"/>
  <link rel="stylesheet" href="../../assets/css/shared/iconly.css"/>
</head>

<body>
<div id="app">
  <div id="main" class="layout-horizontal">
    <header class="mb-5">
      <div class="header-top">
        <div class="container">
          <div class="logo">
            <a href="index.html"><img src="../../assets/images/logo/logo.svg" alt="Logo"/></a>
          </div>
          <div class="header-top-right">
            <div class="dropdown">
              <a href="#" id="topbarUserDropdown"
                 class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                 data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar avatar-md2">
                  <img src="../../assets/images/faces/1.jpg" alt="Avatar"/>
                </div>
                <div class="text">
                  <h6 class="user-dropdown-name"><?php echo $_SESSION['login']?></h6>
                  <p class="user-dropdown-status text-sm text-muted">
                    Member
                  </p>
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                <li><a class="dropdown-item" href="#">Профиль</a></li>
                <li><a class="dropdown-item" href="#">Настройки</a></li>
                <li>
                  <hr class="dropdown-divider"/>
                </li>
                <li>
                  <a class="dropdown-item" href="/admin/logout/">Выход</a>
                </li>
              </ul>
            </div>

            <!-- Burger button responsive -->
            <a href="#" class="burger-btn d-block d-xl-none">
              <i class="bi bi-justify fs-3"></i>
            </a>
          </div>
        </div>
      </div>
      <nav class="main-navbar">
        <div class="container">
          <ul>
            <li class="menu-item">
              <a href="index.html" class="menu-link">
                <span><i class="bi bi-grid-fill"></i> Dashboard</span>
              </a>
            </li>
            <li class="menu-item">
              <a href="index.html" class="menu-link">
                <span><i class="bi bi-grid-fill"></i> Dashboard</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>