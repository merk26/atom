# atom
Микро HMVC Framework на PHP/JS.

## Структура
+ **Configuration** - файлы конфигурации
    + *permission.inc* - описание ролей (прав доступа)
+ **Core** - базовые классы/функции 
+ **Extension** - пользовательские дополнения для сторонних библиотек
+ **Layouts** - шаблоны отображения
+ **logs** - логи работы, по умолчанию уровня ***debug***
+ **Models** - сущности приложения
+ **Modules** - обработчики запросов (контроллеры)
+ **public** - публичная директория
    + **assets** - ресурсы
    + *index.php* - точка входа приложения
+ **vendor**  - сторонние библиотеки

В качестве шаблонизатора используется нативный PHP шаблонизатор [Plates](http://platesphp.com/).
Для работы с базой данных MySQL используется [PHP-MySQLi-Database-Class](http://github.com/joshcam/PHP-MySQLi-Database-Class).

Сторонний [Логер](https://github.com/apix/log).

## Принцип работы
Разберем  **GET** запрос:

    /news?id=1

Равнозначные запросы

    /new/index/id/1
    /news/index?id=1
    
1. Определяется тип запроса, если запрос отличный от **GET**, то считается, что запрос **POST** (т.е. методы **DELETE** и **PUT** будут исполняться так **POST**)
2. Первый параметр запроса - *пространственное имя контроллера* (соответствует папке в директории *Modules*), к этом имени будет подставлен тип запроса, в данном случае пространственное имя будет **Modules/news/get**.
3. Второй параметр запроса - наименование класса, которые будет вызываться (соответствует наименованию файла с расширением *.php* в **Modules/news/get**), по умолчанию = **index**.
4. Все остальные параметры url будут преобразованы в параметры запроса.
5. Создается экземпляр класса  **Modules/news/get/news/index**.
6. Проверяется соответствие  привилегий пользователя и привилегий вызываемого модуля.
7. Если привилегий достаточно, то исполняется код контроллера.
8. Результаты работы контроллера выводятся командой **echo**.

## Контроллеры
**GET** - вызывается при *GET* запросе, находится в папке **Modules/имя_модуля/get/имя_контроллера**. Возращаемое значение - HTML код, результат работы Plates.

Наследуется от **AbstractGetController**.

Пример:
```php
<?php

namespace Modules\auth\get;

use \Modules\AbstractGetController;
use \Models\Client;

class index extends AbstractGetController
{

	protected $_p = PERMISSION_DEFAULT;

	function process(): void
	{
		$this->res['title'] = "Вход в систему";

		if (Client::ins()->getPermission() & PERMISSION_AUTHORIZED)
			Client::location('/dashboard', true);
	}
}

```


**POST** - вызывается при всех остальных типах запросов, результат работы JSON-строка.
Наследуется от **AbstractPostController**.

Пример:
```php
<?php

namespace Modules\auth\post;

use Core\Exception\ClientPostException;
use \Core\Log;
use \Modules\AbstractPostController;
use \Models\User;
use \Models\Phone;

class auth_check extends AbstractPostController
{
    protected $_p = PERMISSION_DEFAULT;
    protected $phone = '';
    protected $password;
    protected $remember;
    protected $id_user;

    function process(): void
    {
        $phone = new Phone($this->phone);

        if ($phone->IsValid() === false)
            throw new ClientPostException("Неверный номер телефона (" . $this->phone . ")");

        $pass = '$2y$10$ZHXPqq07vfhhLaMJlNJD/.LFPjoMHKhpdow1XQpFK.co2A/7er2Ii'; //123

        if (password_verify($this->password, $pass)) {
            $_SESSION['user'] = new User($this->phone);
            Log::F()->info('Успешная авторизация с помощью логина и пароля.');
            $res['success'] = true;
        } else
            throw new ClientPostException("Неверный пароль.");
    }
}
```