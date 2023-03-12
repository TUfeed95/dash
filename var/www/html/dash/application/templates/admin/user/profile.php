<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/application/templates/admin/header.php'?>

	<div class="content-wrapper container">
		<div class="page-heading">
			<h3>Профиль пользователя</h3>
		</div>
    <div class="page-content">
      <section id="multiple-column-form">
        <div class="row match-height">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Основная информация</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form id="formBasicInformation" method="post">
                    <input type="hidden" name="token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="first-name-column">Имя</label>
                          <input type="text" id="first-name-column" class="form-control" value="<?php echo $user->firstname ?>" placeholder="Имя" name="firstname">
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="last-name-column">Фамилия</label>
                          <input type="text" id="last-name-column" class="form-control" value="<?php echo $user->lastname ?>" placeholder="Фамилия" name="lastname">
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="email-id-column" class="form-required">E-mail</label>
                          <input type="email" id="email-id-column" class="form-control" name="email" value="<?php echo $user->email ?? '' ?>" placeholder="Email" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="login-floating" class="form-required">Логин</label>
                          <input type="text" id="login-floating" class="form-control" name="login" value="<?php echo $user->login ?? '' ?>" placeholder="Логин" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="city-column">Город</label>
                          <input type="text" id="city-column" class="form-control" value="<?php echo $user->city ?? '' ?>" placeholder="Город" name="city">
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-1 mb-1">
                          Сохранить
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
	</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/application/templates/admin/footer.php'?>