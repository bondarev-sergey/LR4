"use strict";

$(function () {
  $("#auth-button").click(function () {
    $("#modal-1").addClass("modal_active");
    $("body").addClass("hidden");
  });

  $("#registration-button").click(function () {
    $("#modal-2").addClass("modal_active");
    $("body").addClass("hidden");
  });

  $(".modal__close-button").click(function () {
    $("#modal-1, #modal-2").removeClass("modal_active");
    $("body").removeClass("hidden");
  });
  $("#other-form-1").click(function () {
    $("#modal-1").removeClass("modal_active");
    $("#modal-2").addClass("modal_active");
  });
  $("#other-form-2").click(function () {
    $("#modal-2").removeClass("modal_active");
    $("#modal-1").addClass("modal_active");
  });
});

$(".modal").mouseup(function (e) {
  let modalContent = $(".modal__content");
  if (!modalContent.is(e.target) && modalContent.has(e.target).length === 0) {
    $(this).removeClass("modal_active");
    $("body").removeClass("hidden");
  }
});

let reg1 =
  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
let reg2 = /^((\+7|7|8)+([0-9]){10})$/;
let reg3 = /(?!^[a-zA-Z]*$){6,}/;
let reg4 = /[а-яА-Я]{6,30}/;

document.addEventListener("DOMContentLoaded", function () {
  const registration_form = document.getElementById("registration-form");
  registration_form.addEventListener("submit", formSend);

  async function formSend(e) {
    e.preventDefault();

    let error = formValidate(registration_form);
    console.log(registration_form);
    let formData = new FormData(registration_form);
    if (error === 0) {
      let response = await fetch('registration.php', {
        method: 'POST',
        body: formData,
      });
      if (response.ok) {
        let result = await response.json();
        alert("Регистрация прошла успешно");
        //console.log(result);
        registration_form.reset();
        $("#modal-2").removeClass("modal_active");
        $("body").removeClass("hidden");
        window.location.reload();
      } else {
        alert("Ошибка");
      }
    } else {
      alert("Заполните обязательно поля");
    }
  }

  function formValidate(form) {
    let error = 0;
    let formReq = form.querySelectorAll("._req");

    for (let i = 0; i < formReq.length; i++) {
      const input = formReq[i];
      formRemoveError(input);

      if (input.classList.contains("_email")) {
        if (emailTest(input)) {
          formAddError(input);
          alert(
            "Неверно введена почта. Пример правильной почты: ivanov@gmail.com"
          );
          error++;
        }
      } else if (
        input.classList.contains("form_input_checkbox") &&
        input.checked === false
      ) {
        formAddError(input);
        alert(
          "Чтобы зарегистрироваться, дайте свое согласие на обработку персональных данных"
        );
        error++;
      } else if (input.value === "") {
        formAddError(input);
        error++;
      } else if (input.classList.contains("_phone")) {
        if (phoneTest(input)) {
          formAddError(input);
          alert(
            "Телефон должен быть введен таким образом: +79001111111 или 89045556677"
          );
          error++;
        }
      } else if (input.classList.contains("_name")) {
        if (nameTest(input)) {
          formAddError(input);
          alert("Имя должно содержать только кириллицу");
          error++;
        }
      } else if (input.classList.contains("_psw")) {
        if (passwordTest(input)) {
          formAddError(input);
          alert(
            "Пароль допускает только не менее 6 символов. Также должен содержать по " +
              "крайней мере одной цифры, заглавной или строчной буквы."
          );
          error++;
        }
      } else if (input.classList.contains("_repeat-psw")) {
        if (passwordTest(input)) {
          formAddError(input);
          alert(
            "Пароль допускает только не менее 6 символов. Также должен содержать по " +
              "крайней мере одной цифры, заглавной или строчной буквы."
          );
          error++;
        }
      } else {
        if (input.value === "") {
          formAddError(input);
          error++;
        }
      }
      if (input.classList.contains("_psw")) {
        if (input.value !== formReq[i + 1].value) {
          formAddError(input);
          alert("Пароли должны совпадать");
          error++;
        }
      }
    }
    return error;
  }

  const auth_form = document.getElementById("auth-form");
  auth_form.addEventListener("submit", formSendAuth);

  async function formSendAuth(e) {
    e.preventDefault();

    let error = formValidate(auth_form);
    console.log(error);
    let formData = new FormData(auth_form);

    if (error === 0) {
      let response = await fetch("login.php", {
        method: "POST",
        body: formData,
      });
      if (response.ok) {
        let result = await response.json();
        alert("Авторизация прошла успешно");
        //console.log(result.form);
        auth_form.reset();
        $("#modal-1").removeClass("modal_active");
        $("body").removeClass("hidden");
        window.location.reload();
      } else {
        alert("Ошибка");
      }
    } else {
      alert("Заполните обязательно поля");
    }
  }

  function formAddError(input) {
    input.parentElement.classList.add("_error");
    input.classList.add("_error");
  }
  function formRemoveError(input) {
    input.parentElement.classList.remove("_error");
    input.classList.remove("_error");
  }
  function nameTest(input) {
    return !reg4.test(input.value);
  }
  function emailTest(input) {
    return !reg1.test(input.value);
  }
  function phoneTest(input) {
    return !reg2.test(input.value);
  }
  function passwordTest(input) {
    return !reg3.test(input.value);
  }
});
