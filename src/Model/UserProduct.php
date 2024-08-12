<?php

namespace Model;
use Core\src\Model\Model;

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $quantity;

    public function __construct(int $id, int $userId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public static function create(int $userId, int $productId, int $quantity)
    {
        $stmt = self::getPDO()->prepare('INSERT INTO user_products (user_id, product_id, quantity) 
                                    VALUES (:user_id, :product_id, :quantity)');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getCartByUserId(int $userId):?array
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM user_products up 
                                        WHERE  up.user_id = :userId ');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetchAll();

        $userProducts = [];
        foreach ($data as $userProduct) {
            $userProducts[] =  new UserProduct($userProduct['id'], $userProduct['user_id'],
                $userProduct['product_id'], $userProduct['quantity']);
        }

        return $userProducts;
    }

    public static function getCartByUserIdAndProductId(int $userId, int $productId):?array
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM user_products up 
                                        WHERE  up.user_id = :userId  AND product_id = :productId ');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);

        $data = $stmt->fetchAll();

        $userProducts = [];
        foreach ($data as $userProduct) {
            $userProducts[] =  new UserProduct($userProduct['id'], $userProduct['user_id'],
                $userProduct['product_id'], $userProduct['quantity']);
        }

        return $userProducts;

    }

    public static function deleteCartByUserId(int $userId, int $productId)
    {
        $stmt = self::getPDO()->prepare('DELETE FROM user_products up 
                                        WHERE  up.user_id = :userId  AND product_id = :productId ');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public static function getCount($userId):?int
    {
        $stmt = self::$pdo->prepare('SELECT SUM(user_products.quantity)  
                                                FROM user_products 
                                                    WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $sum = $stmt->fetch();

        if(isset($sum['sum'])) {
            return $sum['sum'];
        }

        return null;
    }

    public static function updateCountPlus($userId, $productId)
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products SET quantity = quantity + 1 
                                                                    WHERE user_id = :userId 
                                                                        and product_id = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public static function updateCountMinus($userId, $productId)
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products SET quantity = quantity - 1 
                                                                    WHERE user_id = :userId 
                                                                        and product_id = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }


}