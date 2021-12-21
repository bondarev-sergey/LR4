<?php
session_start();
unset($_SESSION['user']);
header('Location: index.php');
echo json_encode(['success' => true]);
