<?php
header('Content-Type: application/json');
//сообщаем браузеру, что ответ будет в формате JSON
require 'db.php';

$errors = [];

//логика проверки полей

$login = $_POST['login'];
$password = $_POST['psw'];

$login = htmlspecialchars($login, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$password = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');


$login_check = $connection->prepare("SELECT * FROM adsiteuser WHERE AdSiteLogin=?");
$login_check->execute([$login]);
$login_check = $login_check->fetchAll();

if (count($login_check) != 1){
    array_push($errors, "login");
    echo json_encode(['errors' => $errors]);
    die();
}

$password_hash = $login_check[0]['AdSitePasswordHash'];
if (!(password_verify($password, $password_hash)))
{
    array_push($errors, "password");
    echo json_encode(['errors' => $errors]);
    die();
}

session_start();
$_SESSION['user'] = [
    'user_id' => $login_check[0]['AdSiteUserID'],
    'name' => $login_check[0]['AdSiteLogin'],
];

echo json_encode(['success' => true]);
