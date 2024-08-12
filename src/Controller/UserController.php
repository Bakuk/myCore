<?php

namespace Controller;
use Core\src\AuthenticationInterface;
use Core\src\ViewRenderer;
use Model\User;
use Request\RequestLogin;
use Request\RequestRegistrate;

class UserController
{
    private AuthenticationInterface $authenticationService;
    private ViewRenderer $viewRenderer;

    public function __construct(AuthenticationInterface $authenticationService, ViewRenderer $viewRenderer)
    {
        $this->authenticationService = $authenticationService;
        $this->viewRenderer = $viewRenderer;
    }
    public function getRegistrate()
    {
        return $this->viewRenderer->render('get_registrate.phtml', []);
    }
    public function postRegistrate(RequestRegistrate $request)
    {

        $errors = [];

        $name = $request->getName();
        $email = $request->getEmail();
        $password = $request->getPassword();

        $errors = $request->validateRegistrate($_POST);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if (empty($errors)) {
            User::create($name, $email, $hash);
            header('Location: /login');

        }

        return $this->viewRenderer->render(
            'get_registrate.phtml',
            ['errors' => $errors]
        );
    }

    public function getLogin():string
    {
        return $this->viewRenderer->render('get_login.phtml', []);
    }

    public function postLogin(RequestLogin $request):string
    {
        $errors = [];
        $email = $request->getEmail();
        $password = $request->getPsw();

        $errors = $request->validateLogin($_POST);

        if (empty($errors)) {

            $result = $this->authenticationService->login($email, $password);

            if ($result){

                header('Location: /catalog');
            }

            $errors['email'] = 'Такого пользователя нет';
        }

        return $this->viewRenderer->render('get_login.phtml', ['errors' => $errors]);

    }

    public function logout()
    {
        $this->authenticationService->logout();
        header("location: /login");
    }

}