<?php

namespace App\Controllers;

class HomeController extends BaseController //обозначает, что этот класс наследует свойства и логику класса BaseController
{


    public function index()
    {
        //app()->view->render('test', ['name' => 'John']);// дефолтное подключение вида
        return view('home', [ // подключение вида с помощью helpers и тогда надо писать return
            'title' => 'Home page',
            ]);
    }
    public function contact()
    {
        return 'Contact page';
    }
}