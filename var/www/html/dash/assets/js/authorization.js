const formAuthorization = document.getElementById('formAuthorization'); // форма

/**
 * Авторизация пользователя
 * 
 */
async function sendingAuthorizationData() 
{
  let url = '/admin/login-form/'; // адрес авторизации пользователя
  let formData = new FormData(formAuthorization); // данные с фформы

  // отправляем запрос на сервер
  let response = await fetch(url, {
    method: 'POST',
    body: formData,
  });

  // если ответ сервера 200-299 то редиректим на главную, иначе выводим ошибку авторизации
  if (response.ok){
    window.location.href = '/';
  } else {
    formAuthorization.classList.add('error-auth');
  }

}

formAuthorization.addEventListener('submit', (event) => {
  // отключаем перезагрузку страницы во время отправки данных на сервер
  event.preventDefault();
  sendingAuthorizationData();
});
