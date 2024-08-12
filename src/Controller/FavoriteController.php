<?php

namespace Controller;

use Core\src\AuthenticationInterface;
use Core\src\ViewRenderer;
use Model\Favorite;
use Model\Product;
use Request\RequestFavorite;
use Service\FavoriteService;

class FavoriteController
{
    private AuthenticationInterface $authenticationService;
    private FavoriteService $favoriteService;
    private ViewRenderer $viewRenderer;
    public function __construct(AuthenticationInterface $authenticationService, FavoriteService $favoriteService, ViewRenderer $viewRenderer)
    {
        $this->authenticationService = $authenticationService;
        $this->favoriteService =  $favoriteService;
        $this->viewRenderer = $viewRenderer;
    }
    public function getFavoriteProduct()
    {
        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }
        $user = $this->authenticationService->getCurrentUser();

        if (!$user) {
            header('Location: /login');
        }
        $userId = $user->getId();

        $products = Product::getAllByUserIdFavorite($userId);



        $favoriteProducts = Favorite::getFavoriteByUserId($userId);

        return $this->viewRenderer->render('get_favorite.phtml', ['products' => $products,
            'favoriteProducts' => $favoriteProducts]);

    }

    public function addProduct(RequestFavorite $request)
    {

        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }

        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();


        $this->favoriteService->add($userId, $productId);

        header('location: /catalog' );

    }
}