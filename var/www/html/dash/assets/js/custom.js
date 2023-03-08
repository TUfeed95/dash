/**
 * Элемент формы "Основная информация" на странице профиля пользователя
 * @type {HTMLElement}
 */
const formBasicInformation = document.getElementById('formBasicInformation');

/**
 * Текущий год в footer
 * @type {Element}
 */
let yearTag = document.querySelector('#currentYear');
if (yearTag) {
    yearTag.innerHTML = '<p>' + currentYear() + ' &copy; TDash</p>';
}

/**
 * Текущий год
 * @returns {number}
 */
function currentYear()
{
    let toDay = new Date();
    return toDay.getFullYear();
}

let test = document.getElementById('test');
if (test != null) {
    test.addEventListener('click', function (){
        notification("linear-gradient(to right, #ff5f6d, #ffc371)", "Очень умный текст для уведомления");
    })
}

function notification(styleBackground, message)
{
    Toastify({
        text: message,
        duration: 5000,
        newWindow: false,
        close: false,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true,
        style: {
            background: styleBackground,
        },
    }).showToast();
}

async function sendingBasicInformationUserData()
{
    let url = '/admin/user/basic-information/';
    let formData = new FormData(formBasicInformation);

    let response = await requestFetch(url, formData, 'POST');

    if (response.ok) {

    }
}