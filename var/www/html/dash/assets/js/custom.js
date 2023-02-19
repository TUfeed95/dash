const formRegistration = document.getElementById('formRegistration'); // форма регистрации
const formAuthorization = document.getElementById('formAuthorization'); // форма авторизации

/**
 * Отправка формы регистрации
 *
 * @returns {Promise<void>}
 */
async function sendingRegistrationData()
{
  let url = '/admin/register-form/';
  let formData = new FormData(formRegistration);
  // поле подтверждения пароля отправлять не нужно, проверятся сразу на фронте.
  formData.delete('confirm-password');

  let password = document.getElementById('password');
  let confirmPassword = document.getElementById('confirm-password');

  // подтверждение пароля
  if (password.value === confirmPassword.value) {
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });

    if (response.ok) {
      let res = await response.json();
      if (res['email']) {
        messageForForm('Электронный адрес занят');
      }

      if (res['login']) {
        messageForForm('Логин занят');
      }

    } else {
      console.log('Произошла ошибка запроса на сервер: ' + response.statusText);
    }

  } else {
    messageForForm('Пароли не совпадают');
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
 * @param message
 */
function messageForForm(message)
{

  let div = document.createElement('div');
  let text = document.createElement('p');

  div.classList.add('error');
  text.classList.add('error-msg');

  text.innerHTML = message;

  div.append(text);

  formRegistration.prepend(div);

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
      messageForForm('Логин или пароль неверные');
    }
  } else {
    console.log('Произошла ошибка запроса на сервер: ' + response.statusText);
  }
}

formAuthorization.addEventListener('submit', (event) => {
  event.preventDefault();
  messageErrorClear();
  sendingAuthorizationData();
});

formRegistration.addEventListener('submit', (event) => {
  event.preventDefault();
  messageErrorClear();
  sendingRegistrationData();
});