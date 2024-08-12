<?php

namespace Model;

use Core\src\Model\Model;

class Favorite extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    public function __construct(int $id, int $userId, int $productId)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
    }

    public static function create(int $userId, int $productId)
    {
        $stmt = self::getPDO()->prepare('INSERT INTO favorites (user_id, product_id) 
                                    VALUES (:user_id, :product_id)');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public static function getFavoriteByUserIdAndProductId(int $userId, int $productId):?array
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM favorites f 
                                        WHERE  f.user_id = :userId  AND product_id = :productId ');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);

        $data = $stmt->fetchAll();

        $favoriteProducts = [];
        foreach ($data as $favoriteProduct) {
            $favoriteProducts[] =  new Favorite($favoriteProduct['id'], $favoriteProduct['user_id'],
                $favoriteProduct['product_id']);
        }

        return $favoriteProducts;

    }

    public static function getFavoriteByUserId(int $userId):?array
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM favorites f 
                                        WHERE  f.user_id = :userId ');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetchAll();

        $favoriteProducts = [];
        foreach ($data as $favoriteProduct) {
            $favoriteProducts[] =  new Favorite($favoriteProduct['id'], $favoriteProduct['user_id'],
                $favoriteProduct['product_id']);
        }

        return $favoriteProducts;
    }

    public static function getCount($userId):?int
    {
        $stmt = self::$pdo->prepare('SELECT COUNT(*)  
                                                FROM favorites f 
                                                    WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $sum = $stmt->fetch();

        if(isset($sum['count'])) {
            return $sum['count'];
        }

        return null;
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
}