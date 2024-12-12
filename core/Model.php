<?php

namespace PHPFramework;

use Valitron\Validator;

abstract class Model extends \Illuminate\Database\Eloquent\Model //класс для создания моделей
{


    protected $fillable = []; //нужен для того, чтобы указывать, какие поля мы хотим принимать для работы с ними, чтобы не получить лишние поля
    public  $attributes = []; //разрешённые аттрибуты на основе прошлого массива
    protected array $rules = []; //пустой массив с правилами валидации

    protected array $labels = [];
    protected array $errors = [];
    public function loadData(): void
    {
        $data = request()->getData(); //будет возвращён массив данных из post или get в зависимости от метода запроса
        foreach ($this->fillable as $field){
            if (isset($data[$field])) { //проверяем, существует ли в массиве data такой ключ который нам передали
                $this->attributes[$field] = $data[$field]; //если такое поле есть, то забираем из массива data данные по этому же ключу
            } else {
                $this->attributes[$field] = ''; //иначе записываем пустую строку
            }
        }
    }

    public function validate($data = [], $rules = [], $labels = []): bool
    {
        if (!$data){
            $data = $this->attributes; //если данные не передавались, то используем данные из свойства атрибуты класса
        }
        if (!$rules){
            $rules = $this->rules; //если правила не передавались, то используем данные из свойства правила класса
        }
        if (!$labels){
            $labels = $this->labels;
        }
        Validator::langDir(WWW . '/lang'); // указываем путь со всем переводами на все языки
        Validator::lang('ru'); //ставим русский язык
        $validator = new Validator($data); //создаем новый экземпляр класса валидатор, передаем данные для валидации
        $validator->rules($rules); // передаем правила валидации через метод rules()
        $validator->labels($labels);
        if ($validator->validate()){
            return true;
        } else {
            $this->errors = $validator->errors(); //записываем в свойство errors все ошибки, которые передает валидатор
            return false;
        }

    }

    public function getErrors() //метод для получения ошибок, возвращает массив ошибок
    {
        return $this->errors;
    }
}