<?php
//создаем php doc и указываем, что нам доступно свойство, которое является экземпляром класса Application и это переменная app
/** @var \PHPFramework\Application $app */

//файлы маршрутов, обращаемся к объекту приложения app и через класс маршрута router вызываем методы
//первый параметр - путь, второй какой будет использован контроллер и его действие или callback, затем объявляем какими методами запроса он будет доступен
//добавляем маршруты в таблицу маршрутов, метод add добавляет маршрут get и post, так же можно добавить маршрут с конкретным методом запроса get или post
use App\Controllers\HomeController;
use App\Controllers\UserController;// импорт пространств имён для упрощения записи

$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/register', [UserController::class, 'register']);
$app->router->post('/register', [UserController::class, 'store']); //форма регистрации отправляет данные методом post, потому нужен этот маршрут
$app->router->get('/login', [UserController::class, 'login']);


//для добавления конкретного метода запроса описали методы в классе router
//$app->router->get('test', [\App\Controllers\HomeController::class, 'test']);//вызываем контроллер и метод данного контроллера
//$app->router->post('/contact/', [\App\Controllers\HomeController::class, 'contact']);

//адрес для просмотра конкретного поста/товара и тд для запроса из базы данных
//создаем регулярное выражение, создаем карман в () - это всё, что будет запомнено, для того, чтобы записать это в строковую переменную используется синтаксис
//?P<> в <> пишем название переменной, объявляем в [] доступные символы - a-z, 0-9 и -, /? означает, что / в конце может быть, а может не быть
//для этого всего используем callback функцию, которая возвращает конкретный пост
/*$app->router->get('/post/(?P<slug>[a-z0-9-]+)/?', function (){
    return '<p>Some post</p>';
});*/

//dump($app->router->getRoutes());
