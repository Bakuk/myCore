<?php

namespace Model;
use Core\src\Model\Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private  string $password;

    public function __construct(int $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }


    public static function all():array
    {
        $stmt = self::getPDO()->query('SELECT * FROM users');
        $data = $stmt->fetchAll();
        return static::hydrate($data);
    }

    public static function create(string $name, string $email, string $password)
    {
        $stmt = self::getPDO()->prepare('INSERT INTO users (name, email, password) 
                                    VALUES (:name, :email, :password)');
        $stmt->execute(['name' => $name, 'email' => $email,
            'password' => $password]);

    }



    public static function getByEmail(string $email): ?User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        $data =  $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        return new User($data['id'], $data['name'], $data['email'], $data['password']);

    }

    public static function getByOneId(int  $id): ?User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);

        $data =  $stmt->fetch();

        if(empty($data)) {
            return null;
        }

        return new User($data['id'], $data['name'], $data['email'], $data['password']);

    }

    private static function hydrate(array $data): array
    {
        $users = [];
        foreach ($data as $user) {
            $users[$user['id']] =  new User($user['id'], $user['name'],
                $user['email'],
                $user['password']);
        }

        return $users;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}