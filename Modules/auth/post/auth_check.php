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