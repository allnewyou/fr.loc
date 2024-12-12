<?php
#определение корневой константы, присвоить константе ROOT путь к корневой папке проекта
define ("ROOT", dirname(__DIR__));
#присваиваем константе CONFIG  путь к папке config, корневая папка + /config
const WWW = ROOT . '/public';
const CONFIG = ROOT . '/config';

const HELPERS = ROOT . '/helpers';

const APP = ROOT . '/app';

const CORE = ROOT . '/core';

const VIEWS = APP . '/Views';

const LAYOUT = 'default';

const PATH = 'https://fr.loc';

const DB_SETTINGS = [ // константа с настройками базы данных
    'driver' => 'mysql',
    'host' => 'MySQL-8.2',
    'database' => 'fr_loc',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'port' => 3306,
    'prefix' => '',
];