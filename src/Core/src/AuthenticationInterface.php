<?php

namespace Core\src;

use Model\User;

interface AuthenticationInterface
{
    public function check(): bool;
    public function login(string $email, string $password): bool;
    public function getCurrentUser(): ?User;
}