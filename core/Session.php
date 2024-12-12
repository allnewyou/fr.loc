<?php

namespace PHPFramework;

class Session
{

    public function __construct()
    {
        session_start(); // вызывает старт сессии
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;// записываем значение в сессию по ключу
    }

    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default; //получаем значение из сессии, если оно есть
    }

    public function has($key): bool
    {
        return isset($_SESSION[$key]); //проверяем есть ли такой ключ в сессии
    }

    public function remove($key): void
    {
        if (isset($_SESSION[$key])){
            unset($_SESSION[$key]); //если есть значение с таким ключом, то удаляем его
        }
    }

    public function setFlash($key, $value): void //создание flash сообщений, которые один раз записываются в сессию и сразу из неё удаляются
    {
        $_SESSION['flash'][$key] = $value; //конвенция ['flash']
    }

    public function getFlash($key, $default = null)
    {
        if (isset($_SESSION['flash'][$key])){ //если такая флеш сессия есть, то удаляем её и записываем в пермеменную её значение
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
        }
        return $value ?? $default; //если значение есть, то возвращаем его, если нет, то ничего не аозвращаем
    }

}