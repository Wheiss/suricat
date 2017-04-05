<?php

//FRONT CONTROLLER

// 1. Настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/components/Autoload.php');

// 3. Старт сессии
session_start();

// 4. Вызов Router
$router = new Router();
$router->run();