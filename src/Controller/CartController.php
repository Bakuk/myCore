<?php

namespace Controller;

use Core\src\AuthenticationInterface;
use Core\src\ViewRenderer;
use Model\Product;
use Model\UserProduct;

class CartController
{
    private AuthenticationInterface $authenticationService;
    private ViewRenderer $viewRenderer;
    public function __construct(AuthenticationInterface $sessionAuthenticationService, ViewRenderer $viewRenderer)
    {
        $this->authenticationService = $sessionAuthenticationService;
        $this->viewRenderer = $viewRenderer;
    }
    public function getCart():string
    {
        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }
        $user = $this->authenticationService->getCurrentUser();

        if (!$user) {
            header('Location: /login');
        }
        $userId = $user->getId();

        $products = Product::getAllByUserId($userId);
        $userProducts = UserProduct::getCartByUserId($userId);

        return $this->viewRenderer->render('get_cart.phtml', [
            'products' => $products,
            'userProducts' => $userProducts
        ]);
    }
}