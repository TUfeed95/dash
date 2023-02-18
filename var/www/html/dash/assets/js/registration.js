const formRegistration = document.getElementById('formRegistration'); // форма

async function sendingRegistrationData()
{
  let url = '/admin/register-form/';
  let formData = new FormData(formRegistration);
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

    } else {
      console.log('Произошла ошибка запроса на сервер: ' + response.statusText);
    }

  } else {
    console.log('Пароли разные.');
  }


}


formRegistration.addEventListener('submit', (event) => {
  event.preventDefault();
  sendingRegistrationData();
});