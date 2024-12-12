<?php

$start_framework = microtime(true);
# проверка версии модуля php, чтобы не было ошибок, если версия ниже 8, то должно выдавать ошибку
if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

#запросить один раз файл по адресу: директория данного файла - выходим на кровень выше (/../),
#идем в папку config, запрашиваем файл config.php
require_once __DIR__ . '/../config/config.php';
#подключаем файл автозагрузчика композера по адресу, корневая папка проекта(определённая с помощью константы
#из файла config.php, который был подключен выше) - идём в папку vendor, ищем файл autoload.php
require_once ROOT . '/vendor/autoload.php';
require_once HELPERS . '/helpers.php'; //подключаем файл helpers с помощью константы в config
//создали объект класса Application - переменная app
$app = new \PHPFramework\Application();
require_once CONFIG . '/routes.php';
$app->run();



//dump(request()->getMetod());
//dump(request()->isGet());
//dump(request()->isPost());
//dump(request()->isAjax());
//dump(request()->get('page'));

# вывод количетсво времени, требуемого для выполнения скрипта
//dump("Time: ".microtime(true) - $start_framework);
