<?php

function app(): \PHPFramework\Application
{
    return \PHPFramework\Application::$app;
}

function request(): \PHPFramework\Request
{
    return app()->request;//обращаемся с помощью функции app(), которое возвращает объект класса Application и обращаемся к его свойству request
}

function response(): \PHPFramework\Response
{
    return app()->response;//обращаемся с помощью функции app(), которое возвращает объект класса Application и обращаемся к его свойству request
}

function session(): \PHPFramework\Session
{
    return app()->session;
}

function view($view = '', $data = [], $layout = ''): string|\PHPFramework\View // пустая строка нужна, чтобы можно было не передавать никаких параметров и вместо этого метода вызывался экземпляр класса view
{
    if ($view){
        return app()->view->render($view, $data, $layout); //если передан параметр view, то вызываем метод рендера вида
    }
    return app()->view; //иначе возвращаем экземпляр класса view
}

function abort($error = '', $code = 404) //функция для подключения видов ошибок (404)
{
    response()->setResponseCode($code); //устанавливаем код ошибки
    echo view("errors/{$code}", ['error' => $error], false); //выводим на экран вид для конкретной ошибки и присваиваем ключу 'error' значение $error
    die;
}

function base_url($path = ''): string
{
    return PATH . $path;
}

function get_alerts(): void //функция для получения уведомлений
{
    if (!empty($_SESSION['flash'])){ //если массив сессии не пуст, то проходимся по каждому флеш сообщению
        foreach ($_SESSION['flash'] as $k => $v){
            echo view()->renderPartial("incs/alert_{$k}", ["flash_{$k}" =>
            session()->getFlash($k)]); //выводим на экран часть вида (уведомление), указываем где оно находится и вторым параметром передаём переменную
        }
    }
}

function get_errors($fieldname): string
{
    $output = '';
    $errors = session()->get('form_errors'); //записываем в переменную все ошибки
    if (isset($errors[$fieldname])){ //если в переменной по данному ключу что то есть
        $output .= '<div class="invalid-feedback d-block"><ul class="list-unstyled">'; //открываем два атрибута и создаем отдельный блок сайта со списком
        foreach ($errors[$fieldname] as $error){ //проходимся по каждому элементу из списка ошибок
            $output .= "<li>$error</li>"; //записываем каждую ошибку в переменную
        }
        $output .= '</ul></div>';

    }
    return $output;
}

function get_validation_class($fieldname): string //проверка валидности для форм и отправка класса для окрашивания/стилизации формы
{
    $errors = session()->get('form_errors'); //записываем в переменную все ошибки
    if (empty($errors)){
        return '';
    }
    return isset($errors[$fieldname]) ? 'is-invalid' : 'is-valid';
}

function old($fieldname): string
{
    return  isset(session()->get('form_data')[$fieldname]) ? h(session()->get('form_data')[$fieldname]) : '';  //проверяем существует ли в сессии данные по ключу form data (данные заполненной формы), если есть, то должны вернуться старые значения полей перед отправкой формы
}

function h($str): string//функция, чтобы сохранять данные в исходном виде игнорируя специальные символы html
{
    return htmlspecialchars($str, ENT_QUOTES); //обертка для перевода кода специальных символов html, функция для экранирования
}
function get_csrf_field(): string //вспомогательный метод для проверки на ссрф токен
{
    return '<input type="hidden" name="csrf_token" value="'. session()->get('csrf_token') .'">'; //создаем скрытое поле и кладём в него ссрф токен
}

function get_csrf_meta(): string //тот же самый метод, но только создает мета поле
{
    return '<meta name="csrf-token" content="'. session()->get('csrf_token') .'">'; //создаем скрытое поле и кладём в него ссрф токен
}