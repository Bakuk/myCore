<?php

namespace Request;

use Core\src\Request\Request;

class RequestRegistrate extends Request
{

    public function getName(): string
    {
        return $this->body['name'];
    }

    public function getEmail(): string
    {
        return $this->body['email'];
    }

    public function getPassword(): string
    {
        return $this->body['psw'];
    }
    public function validateRegistrate(array $data): array
    {
        $errors = [];
        if (isset($data['name']) ) {
            $name = $data['name'];
            if(empty($name)) {

                $errors['name'] = "Поле name должно быть заполнено";

            }

            if(strlen($name) < 2) {

                $errors['name'] = "Поле name должно быть больше 3-х букв";

            }
        } else {
            $errors['name'] = "Поле name не указано";
        }

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

        if(isset($data['psw'])  && isset($_POST["psw-repeat"])) {

            $passwordRepeat = $_POST["psw-repeat"];
            $password = $_POST['psw'];
            if(empty($password)) {
                $errors['psw'] = "Поле psw должно быть заполнено";
            }

            if ($password != $passwordRepeat) {
                $errors['psw'] = 'пароль должен совпадать';
            }

        } else {
            $errors['psw'] = "Поля пароля не указаны";
        }

        return $errors;
    }
}