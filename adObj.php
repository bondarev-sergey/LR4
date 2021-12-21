<?php
require 'db.php';
$AdCode = (int)($_GET['AdCode']);
$adObj = $connection->prepare("SELECT * FROM ad WHERE AdCode=?");
$adObj->execute([$AdCode]);
$adObj = $adObj->fetchAll();
$adObj = $adObj[0];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Доска объявлений</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ad.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Noto+Sans:wght@700&family=Open+Sans&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <div class="headerContent">
            <div class="logo-and-title">
                <div class="logo"></div>
                <div class="title">Доска объявлений</div>
            </div>
            <div class="menu">
                <input id="main-button" class="but" type="submit" value="Главная">
                <input id="auth-button" class="but" type="submit" value="Вход">
                <input id="registration-button" class="but" type="submit" value="Регистрация">
            </div>
        </div>
    </header>
    <main role="main">
        <div class="adObj">
            <p class="adObj-header"><?= $adObj['AdHeader'] ?></p>
            <div class="adObj-image"><img src=<?= $adObj['AdPhoto'] ?>></div>
            <p><?= $adObj['AdDescription'] ?></p>
            <p>Стоимость: <?= $adObj['AdPrice'] ?></p>
            <p>Позвонить: <?= $adObj['AdAuthorPhone'] ?></p>
            <button class="more-ad-button" id="more-ad-respond" adcode=<?= $adObj['AdCode'] ?>>Откликнуться на объявление</button>
            <?php if (!isset($_SESSION['user'])) :

                $current_ad = $adObj['AdCode'];

                $query = "SELECT AdSiteUserID FROM adrespond WHERE AdCode=$current_ad";
                $responds = $connection->query($query);

                if ($responds != null) : ?>
                    <p>Отклики: </p>
                    <?php
                    foreach ($responds as $respond) :
                        $query = "SELECT AdSiteLogin, AdSitePhoneNumber FROM adsiteuser WHERE AdSiteUserID=$respond[0]";
                        $respondingUsers = $connection->query($query);
                    ?>
                        <p><?= $respondingUsers['AdSiteLogin'] ?> <?= $respondingUsers['AdSitePhoneNumber'] ?></p>
                <?php endforeach;
                endif; ?>
            <?php endif; ?>
        </div>
        <div class="modal" id="modal-1">
            <div class="modal__content">
                <input class="modal__close-button" type="image" src="img/close-button.svg">
                <h2 class="modal__title">Вход</h2>
                <form class="modal__container" id="auth-form" novalidate>
                    <label for="login"><b>Логин</b></label>
                    <input class="form_input _req" type="text" placeholder="Логин" name="login" required>
                    <label for="psw"><b>Пароль</b></label>
                    <input class="form_input _req" type="password" placeholder="Пароль" name="psw" required>
                    <div class="modal__other-form" id="other-form-1">Регистрация</div>
                    <button class="modal__submit-button" type="submit">Войти</button>
                </form>
            </div>
        </div>
        <div class="modal" id="modal-2">
            <div class="modal__content">
                <input class="modal__close-button" type="image" src="img/close-button.svg">
                <h2 class="modal__title">Регистрация</h2>
                <form class="modal__container" id="registration-form" novalidate>
                    <label for="login"><b>Логин</b>
                        <input class="form_input _req _name" type="text" placeholder="Введите имя (только кириллицей)" id="login" name="login" required pattern="[а-яА-Я]{6,30}">
                    </label>
                    <label for="mail"><b>E-mail</b>
                        <input class="form_input _req _email" type="email" placeholder="ivanov@gmail.com" id="mail" name="mail" required pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$">
                    </label>
                    <label for="tel"><b>Телефон</b>
                        <input class="form_input _req _phone" type="tel" placeholder="+79000000000" id="tel" name="tel" required pattern="^((\+7|7|8)+([0-9]){10})$">
                    </label>
                    <label for="psw"><b>Пароль</b>
                        <input class="form_input _req _psw" type="password" placeholder="Минимальная длина - 6 символов" id="psw" name="psw" required pattern="(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,})$">
                    </label>
                    <label for="repeat-psw"><b>Повторите пароль</b>
                        <input class="form_input _req _repeat-psw" type="password" placeholder="Повторите пароль" id="repeat-psw" name="repeat-psw" required>
                    </label>
                    <input class="form_input_checkbox _req" type="checkbox" name="checkbox" id="checkbox" required>
                    <label for="checkbox">Я даю свое согласие на обработку
                        персональных данных в соответствии с условиями
                    </label>
                    <div class="modal__other-form" id="other-form-2">Войти</div>
                    <button class="modal__submit-button" type="submit">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <div>
            e-mail: s.bond-2000@yandex.ru
        </div>
        <div>
            Сергей Бондарев
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>