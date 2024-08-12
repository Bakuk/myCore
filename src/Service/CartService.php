<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    public function plus(int $userId, int $productId)
    {
        $userProducts = UserProduct::getCartByUserIdAndProductId($userId, $productId);

        if (count( $userProducts) > 0) {
            UserProduct::updateCountPlus($userId, $productId);
        } else {
            UserProduct::create($userId, $productId, 1);

        }
    }

    public function minus(int $userId, int $productId)
    {
        $userProducts = UserProduct::getCartByUserIdAndProductId($userId, $productId);
        if (count($userProducts) > 0) {

            if ($userProducts[0]->getQuantity() == 0) {
                UserProduct::deleteCartByUserId($userId, $productId);
            }
            UserProduct::updateCountMinus($userId, $productId);
        }
    }
}