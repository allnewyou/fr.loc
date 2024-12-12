<?php

namespace PHPFramework;

class Router
{
    //protected Request $request;
    //protected Response $response;
    protected array $routes = [];
    protected $route_params = [];

    //установили два свойства request и response, записали в них те объекты, которые передаем в классе application в параметрах маршрутизатора
    /*public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }*/

    public function __construct( // новый и быстрый способ записи тех же, закомментированных строк
        protected Request $request,
        protected Response $response
    )
    {
    }
    // передаём параметры path отвечает за путь к странице, callback отвечает за функцию, которую будет обрабатывать маршрут
    public function add($path, $callback, $method): self // возвращаем этот же объект, чтобы по цепочке можно было возвращать другие методы
    {
        $path = trim($path, '/');
        if (is_array($method)){
            //если объект метод - массив, то для этого объекта вызываем метод array_map, для которого в параметрах указываем два параметра, первый это callback функцию
            //которую надо выполнить, второй параметр это к какому объекту надо её применить
            $method = array_map('strtoupper', $method);
        } else{
            //если приходит строка, то помещаем эту строку в массив
            $method = [strtoupper($method)];
        }
        // создаем массив маршрутов
        $this->routes[] = [
            'path' => "/$path",
            'callback' => $callback,
            'middleware' => null,
            'method' => $method,
            'needCsrfToken' => true,
        ];
        return $this;
    }
    // создаем такие же методы, как и прошлый, но свой для каждого метода запроса
    public function get($path, $callback): self
    {
        return $this->add($path,$callback, 'GET');
    }

    public function post($path, $callback): self
    {
        return $this->add($path,$callback, 'POST');
    }

    // создали геттер для получения таблицы маршрутов
    public function getRoutes(): array
    {
        return $this->routes;
    }

    //создаем метод диспетчера, который возвращает смешанное значение, а именно путь из строки запроса
    public function dispatch(): mixed
    {
        $path = $this->request->getPath(); //получаем путь
        $route = $this->matchRoot($path); // ищем подходящий маршрут, если он найден, то записываем в переменную true
        if (false === $route){ //если путь не найден, то отправляем код ошибки 404
            abort( 'Test 404 error');
        }
        //если $route['callback'] массив, то записываем в элемент по ключу 0 новый объект класса, а не строку
        if (is_array($route['callback'])){
            $route['callback'][0] = new $route['callback'][0];
        }
        //возвращаем то, что возвращает callback функция
        return call_user_func($route['callback']);
    }

    //принимает запрос и сравнивает маршрут с каждым из таблицы маршрутов
    protected function matchRoot($path): mixed
    {
        foreach ($this->routes as $route){
            if (
                // preg_match возвращает совпадения по регулярным значениям, если они есть, сравниваем наш паттерн с поступившим маршрутом, все совпадения кладем в $matches
                preg_match("#^{$route['path']}$#", "/{$path}",$matches)//##- ограничители шаблона, могут быть любыми ~~, // и тд, ^- якорь начала строки, $ - якорь конца строки
                &&
                //получаем метод запроса и с помощью функции in_array ищем совпадение с методом запроса в массиве $route по значению элемента method
                in_array($this->request->getMetod(), $route['method'])
            ) {

                if (request()->isPost()){ //если запрос пришёл запросом post, то есть была произведена отправка форм например
                    if ($route['needCsrfToken'] && !$this->checkCsrfToken()){ //маршрут требует ссрф токен, но мы не прошли проверку
                        if (request()->isAjax()){ //для методов запроса аякс (асинхронных запросов)
                            echo json_encode([
                                'status' => 'error',
                                'data' => 'Security error',
                            ]);
                            die;
                        } else { //если же это не асинхронный запрос, то заносим в сессию флеш сообщение по статусу error с текстом Ошибка безопасности
//                            session()->setFlash('error', 'Ошибка безопасности');
//                            response()->redirect(); //после чего перенаправляем на ту же страницу
                            abort('Page expired', 419);
                        }
                    }

                }
                foreach ($matches as $k => $v){
                    if (is_string($k)){//проверяем является ли ключ массива строковым значением
                        $this->route_params[$k] = $v;
                    }
                }
                return $route;
            }
        }
        return false;
    }

    public function withoutCsrfToken(): self //метод для отключения надобности CSRF токена
    {
        $this->routes[array_key_last($this->routes)]['needCsrfToken'] = false; //находим маршрут, который выбрал пользователь и меняем параметр needCsrfToken на false
        return $this; //возвращаем текущий объект, это нужно для того, чтобы на одном и том же объекте можно было вызывать несколько методов по цепочке
    }

    public function checkCsrfToken(): bool //проверка на наличие csrf токена
    {
        return request()->post('csrf_token') && (request()->post('csrf_token') == session()->get('csrf_token')); //проверка, пришёл ли csrf токен, возвращает токен, если он есть в массиве _POST и совпадает ли он с тем, который хранится у нас в сессии
    }

}