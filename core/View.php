<?php

namespace PHPFramework;

class View
{

    public string $layout; //свойство для шаблона
    public string $content = ''; //свойства для вида/контента

    public function __construct($layout) //подключаем шаблон
    {
        $this->layout = $layout;
    }

    public function render($view, $data = [], $layout = ''): string //метод для отрисовки шаблона и вида страницы
    {
        extract($data); // извлекаем данные из массива по ключам и создаем переменные, чтобы они были доступны в виде
        $view_file = VIEWS . "/{$view}.php";//путь к файлу с видом
        if (is_file($view_file)) {
            ob_start();// включает буфер для буферизации вывода, запоминаем вывод, но не выводим его
            require $view_file; //если такой файл существует, то подключаем его
            $this->content = ob_get_clean();//закрывает и возвращает наш буфер с выводом
        } else {
            abort("Not found view {$view_file}", 500); // если файл с видом не найден, то вызываем функцию для отображения ошибок, передаем текст ошибки и код ошибки
        }

        if (false === $layout){
            return $this->content; //если мы не хотим подключать шаблон, то сразу выводим вид из буфера
        }

        $layout_file_name = $layout ?: $this->layout;//создаем переменную и если было передано название файла для шаблона, то записываем в неё, если $layout пуст, то оставляем константу default
        $layout_file = VIEWS . "/layouts/{$layout_file_name}.php"; //записываем путь к шаблону
        if (is_file($layout_file)){
            ob_start();
            require_once $layout_file;//если файл существует, то подключаем его один раз
            return ob_get_clean();
        } else {
            abort("Not found layout {$layout_file}", 500);  // если файл с шаблоном не найден, то вызываем функцию для отображения ошибок, передаем текст ошибки и код ошибки
        }
        return '';
    }

    public function renderPartial($view, $data = []): string
    {
        extract($data); // извлекаем данные из массива по ключам и создаем переменные, чтобы они были доступны в виде
        $view_file = VIEWS . "/{$view}.php";//путь к файлу с видом
        if (is_file($view_file)) {
            ob_start();// включает буфер для буферизации вывода, запоминаем вывод, но не выводим его
            require $view_file; //если такой файл существует, то подключаем его
            return ob_get_clean();//закрывает и возвращает наш буфер с выводом
        } else {
            return "File {$view_file} not found"; // если файл с видом не найден, то вызываем функцию для отображения ошибок, передаем текст ошибки и код ошибки
        }
    }


}