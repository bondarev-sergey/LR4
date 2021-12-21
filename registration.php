<?php
header('Content-Type: application/json');
//сообщаем браузеру, что ответ будет в формате JSON
require 'db.php';

$errors = [];

//логика проверки полей

$login_regex = '/[а-яА-Я]{6,30}/';
$email_regex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/';
$phone_regex = '/^((\+7|7|8)+([0-9]){10})$/';
$password_regex = '/(?!^[a-zA-Z]*$){6,}/';

$name = $_POST['login'];
$email = $_POST['mail'];
$phone = $_POST['tel'];
$password = $_POST['psw'];
$repeatPassword = $_POST['repeat-psw'];
$checkbox = $_POST['checkbox'];

$name = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$phone = htmlspecialchars($phone, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$password = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$repeatPassword = htmlspecialchars($repeatPassword, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');

if (!preg_match($login_regex, $name))
{
    array_push($errors, "name");
}
if (!preg_match($email_regex, $email))
{
    array_push($errors, "email");
}
if (!preg_match($phone_regex, $phone))
{
    array_push($errors, "phone");
}
if (!preg_match($password_regex, $password))
{
    array_push($errors, "password");
}
if ($repeatPassword != $password)
{
    array_push($errors, "repeatPassword");
}
if ($checkbox != "on"){
    array_push($errors, "checkbox");
}


if (!empty($errors)) {
   echo json_encode(['errors' => $errors]);
   die();
}

$password = password_hash($password, PASSWORD_DEFAULT);

$email_check = $connection->prepare("SELECT * FROM adsiteuser WHERE AdSiteEmail=?");
$email_check->execute([$email]);
$email_check = $email_check->fetchAll();

if (count($email_check) != 0){
    echo json_encode(['email_check' => false]);
    die();
}

$status = $connection->prepare("INSERT INTO adsiteuser (AdSiteEmail, AdSitePasswordHash, AdSiteLogin, AdSitePhoneNumber) VALUES (?, ?, ?, ?)");
$status->execute([$email, $password, $name, $phone]);

$email_check = $connection->prepare("SELECT * FROM adsiteuser WHERE AdSiteEmail=?");
$email_check->execute([$email]);
$email_check = $email_check->fetchAll();

session_start();
$_SESSION['user'] = [
    'user_id' => $email_check[0]['AdSiteUserID'],
    'name' => $email_check[0]['AdSiteLogin'],
];

echo json_encode(['email_check' => true, 'success' => true]);
