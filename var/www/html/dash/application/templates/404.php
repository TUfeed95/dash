<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Упс! Страница не найдена.</title>
    <link rel="stylesheet" href="/assets/css/main/app.css" />
    <link rel="stylesheet" href="/assets/css/pages/error.css" />
    <link
      rel="shortcut icon"
      href="/assets/images/logo/favicon.svg"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="/assets/images/logo/favicon.png"
      type="image/png"
    />
  </head>

  <body>
    <div id="error">
      <div class="error-page container">
        <div class="col-md-8 col-12 offset-md-2">
          <div class="text-center">
            <img
              class="img-error"
              src="/assets/images/samples/error-404.svg"
              alt="Not Found"/>
            <h1 class="error-title">Упс!</h1>
            <p class="fs-5 text-gray-600">
              Страница, <b><?= $query['path']; ?></b>, которую вы ищете, не найдена.
            </p>
            <a href="/" class="btn btn-lg btn-outline-primary mt-3">На главную</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
