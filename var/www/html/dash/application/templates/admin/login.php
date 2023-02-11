<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Авторизация</title>
  <link rel="stylesheet" href="../../assets/css/custom.css" />
  <link rel="stylesheet" href="../../assets/css/main/app.css" />
  <link rel="stylesheet" href="../../assets/css/pages/auth.css" />
  <link rel="shortcut icon" href="../../assets/images/logo/favicon.svg" type="image/x-icon" />
  <link rel="shortcut icon" href="../../assets/images/logo/favicon.png" type="image/png" />
</head>

<body>
  <div id="auth">
    <div class="row h-100">
      <div class="col-lg-5 col-12" style="position: relative;">
        <div id="auth-left">
          <div class="auth-logo">
            <a href="/"><img src="../../assets/images/logo/logo.svg" alt="Logo" /></a>
          </div>
          <h1 class="auth-title">Авторизация</h1>
          <p class="auth-subtitle">
            Войдите в систему, используя свои учетные данные.
          </p>
          <form id="sendLoginUser" method="post">
            <div class="error">
              <p class="error-msg">Неверный логин или пароль</p>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="text" id="login" name="login" class="form-control form-control-xl" placeholder="Логин" />
              <div class="form-control-icon">
                <i class="bi bi-person"></i>
              </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="password" id="password" name="password" class="form-control form-control-xl" placeholder="Пароль" />
              <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
              </div>
            </div>
            <div class="form-check form-check-lg d-flex align-items-end">
              <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" />
              <label class="form-check-label text-gray-600" for="flexCheckDefault">
                Запомнить
              </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
              Авторизоваться
            </button>
          </form>
          <div class="text-center mt-5 text-lg fs-4">
            <p class="text-gray-600">
              У вас нет учетной записи?
              <a href="/admin/register/" class="font-bold">Зарегистрироваться</a>.
            </p>
            <p>
              <a class="font-bold" href="auth-forgot-password.html">Забыли пароль?</a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right"></div>
      </div>
    </div>
  </div>
  <script src="../../assets/js/loginUser.js"></script>
  <script src="../../assets/js/app.js"></script>
  <script src="../../assets/js/bootstrap.js"></script>
</body>


</html>