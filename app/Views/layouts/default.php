<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0,
        maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= get_csrf_meta() ?>
    <title>PHPFramework :: <?= $title ?? ''; ?></title> <!-- название сайта и потом идет название страницы, если такая переменная передается, то выводим её, если нет то будет пустая строка -->
    <link rel="icon" href="<?= base_url('/favicon.png'); ?>" <!-- подключение иконки сайта над поисковой строкой -->
    <link rel="stylesheet" href="<?= base_url('/assets/bootstrap/css/bootstrap.min.css'); ?>"> <!-- подключаем файл со стилями из фреймворка bootstrap -->
    </head>
<body>

<nav class="navbar navbar-expand-lg bg-dark mb-3" data-bs-theme="dark"> <!-- навбар был скопирован со вкладки компоненты с официального сайта bootstrap -->
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('/') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('/register') ?>">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('/login') ?>">Log in</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php get_alerts(); ?> <!-- возвращает уведомления -->
<?= $this->content; ?> <!-- это обозначения для внедрения в html, php кода-->

<script src="<?= base_url('/assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script><!-- подключаем файл скрипта из фреймворка bootstrap -->
</body>
</html>