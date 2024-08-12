<?php

namespace Model;

use Core\src\Model\Model;

class Order extends Model
{
    private int $id;
    private int $orderNumber;
    private int $userId;
    private string $userName;
    private string $email;
    private  string $phone;
    private  string $address;
    private  string $comment;

    public function __construct(int $id, int $orderNumber, int $userId, string $userName,
                                string $email,
                                string $phone,
                                string $address,
                                string $comment)
    {
        $this->id = $id;
        $this->orderNumber = $orderNumber;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->comment = $comment;
    }

    public static function create(int $userId, string $userName, string $email,
                                  string $phone, string $address, string $comment = null): string
    {
        $orderNumber = mt_rand();
        $stmt = self::getPDO()->prepare('INSERT INTO orders (order_number, user_id, 
                                                                   user_name, email, phone, address, comment) 
                                            values (:orderNumber, :userId, :userName, :email, :phone, :address, :comment) RETURNING id'); //защита от некоректных данных
        $stmt->execute(['orderNumber' => $orderNumber, 'userId' => $userId,
            'userName' => $userName, 'email' => $email, 'phone' => $phone, 'address' => $address, 'comment' => $comment]);
        return $stmt->fetchColumn();
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderNumber(): int
    {
        return $this->orderNumber;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}