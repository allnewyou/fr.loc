<?php

namespace PHPFramework;

use Illuminate\Database\Capsule\Manager as Capsule; //импортируем пространство имён менеджера бд под именем capsule

class Application
{

    #создаем закрытую переменную uri с данными из адресной строки браузера
    protected string $uri;
    # создаем публичную переменную запроса, которая является экземпляром класса Request
    public Request $request;
    public Response $response;
    //создаём свойство класса router с названием rouetr - маршрутизатор
    public Router $router;
    //создаем свойство - экземпляр класса view
    public View $view;
    public Session $session;
    public static Application $app; //создаем свойство данного класса

    #создаем конструктор
    public function __construct()
    {
        self::$app = $this; //обращаемся к свойству этого же класса и записываем в него текущий объект
        //выбираем текущее свойство и получаем из массива SERVER данные из строки запросов и выводим на экран
        //$this->uri = $_SERVER['QUERY_STRING'];
        $this->uri = $_SERVER['REQUEST_URI'];
        #создаем экземпляр класса request и записываем то, чтоь приняли в переменную из этого класса
        $this->request = new Request($this->uri);
        // инициализируем
        $this->response = new Response();
        //добавляем в параметры для маршрутизатора объекты классов для запросов и ответов на эти запросы
        $this->router = new Router($this->request, $this->response);
        $this->view = new View(LAYOUT);
        $this->session = new Session(); //создаем экземпляр класса сессии и создаем сессию
        $this->generateCsrfToken(); //вызываем метод для генерации токена
        $this->setDbConnection();
    }

    public function run()
    {
        echo $this->router->dispatch();
    }

    public function generateCsrfToken(): void //метод для генерации CSRF токена
    {
        if (!session()->has('csrf_token')){//если в сессии ещё нет ключа csrf токена, как и самого токена, то
            session()->set('csrf_token', md5(uniqid(mt_rand(), true))); //генерируем случайный ключ и записываем его в сессию по ключу csrf_token
        }
    }

    public function setDbConnection()
    {
        $capsule = new Capsule(); // создаем экземпляр класса capsule
        $capsule->addConnection(DB_SETTINGS); //передаем метод данного класса для создания подключения к бд и передаем константу со своими настройками
        $capsule->setAsGlobal(); //делаем её глобальной
        $capsule->bootEloquent();
    }


}