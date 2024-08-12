<?php

namespace Model;
use Core\src\Model\Model;

class Product extends  Model
{
    private int $id;
    private string $title;
    private int $cardLabel;
    private string $image;
    private int $priceDiscount;
    private int $priceCommon;

    public function __construct(int $id, string $title, int $cardLabel,
                                string $image, int $priceDiscount, int $priceCommon)
    {
        $this->id = $id;
        $this->title = $title;
        $this->cardLabel = $cardLabel;
        $this->image = $image;
        $this->priceDiscount = $priceDiscount;
        $this->priceCommon = $priceCommon;
    }

    public static function getAll():array
    {
        $stmt = self::getPDO()->query('SELECT * FROM products ');
        $data = $stmt->fetchAll();
        return static::hydrate($data);
    }

    public static function getAllByUserId(int $userId):array
    {
        $stmt = self::getPDO()->prepare('SELECT p.* FROM products p 
                                                    INNER JOIN user_products up 
                                                    ON p.id = up.product_id WHERE up.user_id = :userId');
        $stmt->execute(['userId' => $userId]);

        $data = $stmt->fetchAll();

        return static::hydrate($data);
    }

    public static function getAllByUserIdFavorite(int $userId):array
    {
        $stmt = self::getPDO()->prepare('SELECT p.* FROM products p 
                                                    INNER JOIN favorites f 
                                                    ON p.id = f.product_id WHERE f.user_id = :userId');
        $stmt->execute(['userId' => $userId]);

        $data = $stmt->fetchAll();

        return static::hydrate($data);
    }

    public static function getOne(int $productId): Product
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM products  
                                                     WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);

        $data = $stmt->fetch();

        return new Product($data['id'],
                            $data['title'],
                            $data['card_label'],
                            $data['image'],
                            $data['price_discount'],
                            $data['price_common']);
    }

    private static function hydrate(array $data): array
    {
        $products = [];
        foreach ($data as $product) {
            $products[$product['id']] =  new Product($product['id'], $product['title'],
                $product['card_label'],
                $product['image'],
                $product['price_discount'],
                $product['price_common']);
        }

        return $products;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCardLabel()
    {
        return $this->cardLabel;
    }

    public function getPriceDiscount()
    {
        return $this->priceDiscount;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPriceCommon()
    {
        return $this->priceCommon;
    }


}