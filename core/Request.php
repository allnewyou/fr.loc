<?php

namespace PHPFramework;

class Request
{

    public string $uri;

    public function __construct($uri)
    {
        $this->uri = trim(urldecode($uri), '/'); //декодирует url запрос и удаляет / в конце
    }

    public  function getMetod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    public function isGet(): bool
    {
        return $this->getMetod() == 'GET';
    }
    public function isPost(): bool
    {
        return $this->getMetod() == 'POST';
    }

    public function isAjax(): bool //ассинхронный ли метод запроса
    {
        return isset($_SERVER['HTTP_X_REQUESTED-WITH']) &&
            $_SERVER['HTTP_X_REQUESTED-WITH'] === 'XMLHttpRequest';
    }

    public function get($name, $default = null): ?string // метод может принимать либо строку, либо null для этого перед типом параметра надо написать ?
    {
        return  $_GET[$name] ?? $default; // если в массиве get что-то есть, то верни, если нет, то верни значение default
    }

    public function post($name, $default = null): ?string // метод может принимать либо строку, либо null для этого перед типом параметра надо написать ?
    {
        return  $_POST[$name] ?? $default; // если в массиве post что-то есть, то верни, если нет, то верни значение default
    }

    //возвращает чистый url адрес без гет параметров
    public  function getPath(): string
    {
        return $this->removeQueryString();
    }

    //возвращает гет параметры используя метод getPath
    protected function removeQueryString(): string
    {
        if ($this->uri){
            $params = explode("?", $this->uri);
            return trim($params[0],'/');
        }
        return "";
    }

    public function getData(): array
    {
        $data = [];
        $request_data = $this->isPost() ? $_POST : $_GET; //проверяем каким методом пришли данные, если методом post, то забираем их из массива _POST, иначе из массива _GET
        foreach ($request_data as $k => $v) { //проходим по каждому элементу из $request_data и отдельно берём ключ и значение
            if (is_string($v)){
                $v = trim($v); // если это строка, то избавляемся от лишних пробелов
            }
            $data[$k] = $v; // присваиваем ключ каждому значению
        }

        return $data;
    }

}