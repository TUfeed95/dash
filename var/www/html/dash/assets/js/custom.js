/**
 * Элемент, формы регистрации
 * @type {HTMLElement}
 */
const formRegistration = document.getElementById('formRegistration');
/**
 *  Элемент, формы авторизации
 * @type {HTMLElement}
 */
const formAuthorization = document.getElementById('formAuthorization');

/**
 * Отправка формы регистрации
 *
 * @returns {Promise<void>}
 */
async function sendingRegistrationData()
{
  let url = '/admin/register-form/';
  let formData = new FormData(formRegistration);

  // проверка валидности введенного e-mail
  if (!validateEmail(formData.get('email'))) {
    messageForForm(formRegistration, 'Введите корректный E-mail.');
    return;
  }

  // подтверждение пароля
  if (formData.get('password') === formData.get('confirm-password')) {
    // поле подтверждения, пароль отправлять не нужно, проверяeтся сразу на фронте.
    formData.delete('confirm-password');

    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });

    if (response.ok) {
      let res = await response.json();
      if (res['email']) {
        messageForForm(formRegistration,'Электронный адрес занят');
      }

      if (res['login']) {
        messageForForm(formRegistration,'Логин занят');
      }

    } else {
      console.log('Произошла ошибка запроса на сервер: ' + response.statusText);
    }

  } else {
    messageForForm(formRegistration,'Пароли не совпадают');
  }

}

/**
 * Авторизация пользователя
 *
 */
async function sendingAuthorizationData()
{
  let url = '/admin/login-form/'; // адрес авторизации пользователя
  let formData = new FormData(formAuthorization); // данные с формы
  // отправляем запрос на сервер
  let response = await fetch(url, {
    method: 'POST',
    body: formData,
  });

  if (response.ok){
    let res = await response.json();
    if (res['status']) {
      window.location.href = '/';
    } else {
      messageForForm(formAuthorization,'Неверный логин или пароль.');
    }
  } else {
    console.log('Произошла ошибка запроса на сервер: ' + response.statusText);
  }
}

function messageErrorClear()
{
  let error = document.querySelector('.error');
  if (error) {
    error.remove();
  }
}

/**
 * Выводим блок с сообщением для формы.
 *
 * @param elementForm
 * @param message
 */
function messageForForm(elementForm, message)
{

  let div = document.createElement('div');
  let text = document.createElement('p');

  div.classList.add('error');
  text.classList.add('error-msg');

  text.innerHTML = message;

  div.append(text);

  elementForm.prepend(div);

}

/**
 * Валидация e-mail
 * @param email
 */
function validateEmail(email)
{
  let pattern = /^[\w%.\-+]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/i;
  return pattern.test(String(email));
}

if (formRegistration != null) {
  formRegistration.addEventListener('submit', (event) => {
    event.preventDefault();
    messageErrorClear();
    sendingRegistrationData();
  });
}

if (formAuthorization != null) {
  formAuthorization.addEventListener('submit', (event) => {
    event.preventDefault();
    messageErrorClear();
    sendingAuthorizationData();
  });
}
