<?php require 'db.php' ?>

<?php session_start(); ?>

<?php

$query = "SELECT AdCode FROM ad";
$all_ads = $connection->query($query);
$all_ads = $all_ads->fetchAll();

$ads_max_size = 2;
$ads_last_ad = end($all_ads)['AdCode'];

$query = "SELECT * FROM ad LIMIT $ads_max_size";
$ads = $connection->query($query);
$ads = $ads->fetchAll();

$data_max_page = ceil($ads_last_ad / $ads_max_size);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Доска объявлений</title>
    <link rel="stylesheet" href="style.css">
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
            <?php if (!isset($_SESSION['user'])) : ?>
            <div class="menu">
                <input id="main-button" class="but" type="submit" value="Главная">
                <input id="auth-button" class="but" type="submit" value="Вход">
                <input id="registration-button" class="but" type="submit" value="Регистрация">           
            </div>
            <?php else : ?>
            <div class="menu">
                <div class="greeting">Привет, <?= $_SESSION['user']['name'] ?></div>
                <input id="main-button" class="but" type="submit" value="Главная">
                <a href="logout.php" id="out-button" class="but">Выход</a>
            </div>    
            <?php endif; ?>
        </div>
    </header>
    <main role="main">
        <div class="main__container">
            <?php foreach ($ads as $ad) : ?>
                <div class="ad">
                    <div class="ad-image"><img src=<?= $ad['AdPhoto'] ?>></div>
                    <a href="/adObj.php?AdCode=<?= $ad['AdCode'] ?>">
                        <?= $ad['AdHeader'] ?></a>
                    </a>
                    <p><?= $ad['AdPrice'] ?></p>
                </div>
            <?php
            endforeach;
            ?>
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
        <button class="more-ad-button" id="more_ad_button" data-page="1" data-max-page="<?= $data_max_page ?>">Больше<br>объявлений</button>
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
    <script src="js/ajax.js"></script>
</body>

</html>