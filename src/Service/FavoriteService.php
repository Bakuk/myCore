<?php

namespace Service;

use Model\Favorite;
use Model\UserProduct;

class FavoriteService
{
    public function add(int $userId, int $productId)
    {
        $favoriteProducts = Favorite::getFavoriteByUserIdAndProductId($userId, $productId);


        if(empty($favoriteProducts))  {

            Favorite::create($userId,$productId);

        }
    }
}