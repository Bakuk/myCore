<?php

namespace Service\Authentication;

use Core\src\AuthenticationInterface;
use Model\User;

class SessionAuthenticationService implements AuthenticationInterface
{
    private User $user;
    public function startSession()
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
    }
    public function check(): bool
    {
        self::startSession();

        return isset($_SESSION['user_id']);
    }

    public function login(string $email, string $password): bool
    {
        $user = User::getByEmail($email);

        if (!$user) {
            return false;
        }

        if(!password_verify($password, $user->getPassword())){
            return false;
        }

        session_start();
        $_SESSION['user_id'] = $user->getId();
        return true;

    }

    public function getCurrentUser(): ?User
    {
        if(isset($this->user)){
            return $this->user;
        }

        if (!$this->check()){
            return null;
        }

        self::startSession();

        $userId = $_SESSION['user_id'];

        $this->user = User::getByOneId($userId);

        return $this->user;

    }
    public function logout()
    {
        unset($_SESSION['user_id']);
        session_unset();
    }
}

