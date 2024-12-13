<?php

namespace App\Models;

use PHPFramework\Model;

class User extends Model //здесь указываются уникальные аттрибуты модели
{

    protected $table = 'users'; //ларавель поддерживает конвекцию для таблицы с таким именем, следовательно данная запись нужна только в случае если таблица называется по другому
    public $timestamps = true; //необходимо для того, чтобы не возникало ошибки, если мы не передаем время создания и время обновления новой записи в БД
    protected array $loaded =['name', 'email', 'password', 'confirmPassword']; //принимаем
    protected $fillable = ['name', 'email', 'password']; //сохраняем в БД

    protected array $rules = [

        'required' => ['name', 'email', 'password', 'confirmPassword'],
        'email' => ['email'],
        'lengthMin' => [
            ['password', 6]
        ],
        'equals' => [
            ['password', 'confirmPassword']
        ]

    ];

    protected array $labels = [
        'name' => 'Имя',
        'email' => 'Email',
        'password' => 'Пароль',
        'confirmPassword' => 'Подтверждение пароля',
    ];



}