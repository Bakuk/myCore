<?php

namespace Request;

use Core\src\Request\Request;

class RequestOrder extends Request
{
    public function getName(): string
    {
        return $this->body['name'];
    }

    public function getEmail(): string
    {
        return $this->body['email'];
    }

    public function getPhone(): string
    {
        return $this->body['phone'];
    }

    public function getAddress(): string
    {
        return $this->body['address'];
    }

    public function getComment(): string
    {
        return $this->body['comment'];
    }
    public function validate(array $data): array
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

        if(isset($data['phone'])) {
            $phone = $data['phone'];
            if(empty($phone)) {
                $errors['phone'] = "Поле phone должно быть заполнено";
            }

        } else {
            $errors['psw'] = "Поле телефон не указано";
        }

        if(isset($data['address'])) {
            $address = $data['address'];
            if(empty($address)) {
                $errors['address'] = "Поле address должно быть заполнено";
            }

        } else {
            $errors['address'] = "Поле address не указано";
        }

        return $errors;
    }
}