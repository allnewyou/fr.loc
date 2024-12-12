<?php

namespace PHPFramework;

class Response
{

    public function setResponseCode(int $code): void
    {
        http_response_code($code); //отправка кода ошибки
    }


    public function redirect($url = '') //функция перенаправления, если ссылка указана, то записываем в переменную её
    {
        if ($url){
            $redirect = $url;
        } else {
            $redirect = $_SERVER['HTTP_REFERER'] ?? base_url('/'); //если ссылки нет, то остаемся на той же странице, но если и этого нет, то идём на главную
        }
        header("Location: $redirect");
        die;
    }
}