const sendLoginUser = document.getElementById('sendLoginUser'); // элемент формы

/**
 * Авторизация пользователя
 * 
 */
async function loginUser() 
{
  let urlLoginUser = '/admin/login-form/'; // адрес авторизации пользователя
  let formData = new FormData(sendLoginUser);

  let response = await fetch(urlLoginUser, {
    method: 'POST',
    body: formData,
  });

  if (response.ok){
    window.location.href = '/';
    console.log('Успешно: ' + response.status);
  } else {
    sendLoginUser.classList.add('error-auth');
    console.log('Ошибка: ' + response.status);
  }

}


sendLoginUser.addEventListener('submit', (event) => {
  // отключаем перезагрузку страницы во время отправки данных на сервер
  event.preventDefault();
  loginUser();
});
