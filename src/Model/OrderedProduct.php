<?php

namespace Model;

use Core\src\Model\Model;

class OrderedProduct extends Model
{
    public static function create(int $orderId, int $productId, int $quantity, float $total) : void
    {
        $stmt = self::getPdo()->prepare("INSERT INTO orders_products (order_id, 
                                                                            product_id,     
                                                                            quantity, total) 
                                                VALUES (:orderId, :productId, :quantity, :total)");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'quantity' => $quantity, 'total' => $total]);
    }


}