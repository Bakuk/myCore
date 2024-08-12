<?php

namespace Request;

use Core\src\Request\Request;

class RequestLogin extends Request
{
    public function getEmail(): string
    {
        return $this->body['email'];
    }
    public function getPsw(): string
    {
        return $this->body['psw'];
    }


    function validateLogin(array $data): array
    {
        $errors = [];

        if (isset($data['email']) ) {
            $email = $data['email'];
            if(empty($email)) {
                $errors['email'] = "Поле email должно быть заполнено";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "E-mail адрес '$email' указан неверно.";
            }

        } else {
            $errors['email'] = "Поле email не указано";
        }

        if(isset($data['psw'])) {
            $password = $data['psw'];
            if(empty($password)) {
                $errors['psw'] = "Поле psw должно быть заполнено";
            }

        } else {
            $errors['psw'] = "Поля пароля не указаны";
        }

        return $errors;
    }
}