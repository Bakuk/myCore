<?php

namespace Model;

use Core\src\Model\Model;

class CommentProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private string $comment;

    private string $imageFile;
    public function __construct(int $id, int $userId, int $productId, string $comment, string $imageFile)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->comment = $comment;
        $this->imageFile = $imageFile;
    }

    public static function create(int $userId, int $productId, string $comment, string $imageFile) : void
    {

        $stmt = self::getPdo()->prepare("INSERT INTO comments_product (user_id, 
                                                                            product_id,     
                                                                            comment, image_file) 
                                                VALUES (:userId, :productId, :comment, :imageFile)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'comment' => $comment,
                            'imageFile' => $imageFile]);
    }

    public static function getByProductId(int $productId) : array
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM comments_product  
                                                     WHERE product_id = :productId');
        $stmt->execute(['productId' => $productId]);

        $data = $stmt->fetchAll();

        return static::hydrate($data);
    }

    private static function hydrate(array $data): array
    {
        $commentsProduct = [];
        foreach ($data as $commentProduct) {
            $commentsProduct[$commentProduct['id']] =  new CommentProduct($commentProduct['id'], $commentProduct['user_id'],
                $commentProduct['product_id'],
                $commentProduct['comment'],
                $commentProduct['image_file']);
        }

        return $commentsProduct;
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

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getImageFile(): string
    {
        return $this->imageFile;
    }

}