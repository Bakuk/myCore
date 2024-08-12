<?php

namespace Service;

use Core\src\Model\Model;
use Model\Order;
use Model\OrderedProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{

    public function create(int $userId, string $name, string $email, string $phone, string $address, string $comment)
    {
        $products = Product::getAllByUserId($userId);

        $userProducts = UserProduct::getCartByUserId($userId);

        $pdo = Model::getPDO();

        $pdo->beginTransaction();
        try {

            $orderId = Order::create($userId, $name, $email, $phone, $address, $comment);

            foreach ($userProducts as $userProduct) {
                $product = $products[$userProduct->getProductId()];
                $productId = $userProduct->getProductId();
                $quantity = $userProduct->getQuantity();
                $total = (float)$product->getPriceCommon() * $userProduct->getQuantity();
                OrderedProduct::create($orderId, $productId, $quantity, $total);
            }

            $pdo->commit();
        }catch (\Throwable $e) {
            $pdo->rollBack();
            die($e->getMessage());
        }

    }
}