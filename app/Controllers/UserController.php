<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserController extends BaseController //обозначает, что этот класс наследует свойства и логику класса BaseController
{

    public function register() //метод для реализации регистрации
    {
//        dump(Capsule::insert("insert into users (name, email, password) values (?, ?, ?)", ['Petya', 'petya@mail.com', 'pass3']));


        $users = Capsule::table('users')->select(['id', 'name'])->get(); //обращаемся к классу capsule, вызываем метод, который возвращает таблицу из бд, запрашиваем таблицу users методом get
//        dump($users);

//        $users = Capsule::select('select * from users where id = ? and email = ?', [1]); //для защиты от скл инъекций напрямую параметры не передаем, только через плейсхолдер ? и через запятую передаем значение
//        dump($users);

//        $user = Capsule::table('users')->select(['id', 'name'])->where('id',2)->get(); //обращаемся к классу capsule, вызываем метод, который возвращает таблицу из бд, запрашиваем таблицу users методом get
//        dump($user);

//        $user = Capsule::table('users')->select(['id', 'name'])->where('id',2)->first(); //метод first возвращает одну запись, одномерный массив
//        dump($user->name);


        //данная запись стала доступна благодаря наследования класса model от класса \Illuminate\Database\Eloquent\Model, так как данный класс включает пространство имён класса User
//        $users2 = User::all(); //обращаемся к нашему классу User и вызываем метод, который возвращает все записи
//        dump($users2);
//        foreach ($users2 as $user){
//            echo $user->name; //вывод всех имен пользователей
//        }

//        $users3 = User::query()->select(['id', 'name'])->where('id', '>', 1)->get(); //так же обращаемся к нашему классу USer и выводим конкретного пользователя по условию
//        foreach ($users3 as $user){
//            echo $user->name; //вывод всех имен пользователей
//        }


        return view('user/register', [
            'title' => 'Register page',
            'users' => $users
        ]);
    }

    public function store()
    {
        $model = new User(); //создаем экземпляр класса модели User
        $model->loadData(); //вызываем метод loadData загрузки данных
        if (!$model->validate()){ //если данные из модели не прошли валидацию, то возвращаемся на ту же страницу и показываем ошибки
            session()->setFlash('error', 'Validation errors'); //записываем в сессию и устанавливаем флеш сообщение по ключу error текст validation errors
            session()->set('form_errors', $model->getErrors()); //записываем в сессию все собранные ошибки заполнения формы
            session()->set('form_data', $model->attributes); //записываем в сессию данные, которые нам пришли
        } else { // иначе пробуем записать в БД
//            dump(User::query()->create([ //обращаемся к классу User, к методу create для создания новой записи в бд и реализации регистрации
//               'name' => $model->attributes['name'],
//               'email' => $model->attributes['email'],
//               'password' => $model->attributes['password'],
//            ]));


//            User::query()->create([ //для создания записи в бд обращаемся к классу User к методу запрос к бд и у него вызываем метод создать новую запись
//                'name' => $model->attributes['name'], //обращаемся к каждому атрибуту, который хотим записать и передаем ему значение из нашей модели используя метод атрибуты
//                'email' => $model->attributes['email'],
//                'password' => $model->attributes['password'],
//            ]);

            //unset($model->attributes['confirmPassword']); // мы передаем все атрибуты в методе save(), но поля confirmPassword у нас нет, чтобы не было ошибки мы убираем данный атрибут перед созданием новой записи
            //более короткий способ записи в БД через экземпляр модели вызываем метод save он сохраняет все атрибуты модели
            if ($model->save()){ //если получилось создать новую запись, то
                session()->setFlash('success', 'Thanks for registration'); //записываем во флеш сообщение уведомление об успешной регистрации
            } else {
                session()->setFlash('success', 'Error registration'); //иначе ошибка регистрации
            }


            //dd($model->attributes);
            //session()->setFlash('success', 'Successfully validation');
//            session()->setFlash('info', 'Info message');

//            dump($model->attributes);
//            dump($model->validate());
//            dump($model->getErrors());
        }
        response()->redirect('/register');

       // dd($_POST);
    }

    public function login() //метод для реализации авторизации
    {
        return view('user/login', [
            'title' => 'Login page',
        ]);
    }
}