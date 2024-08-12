<?php

namespace Controller;

use Core\src\AuthenticationInterface;
use Core\src\ViewRenderer;
use Model\Product;
use Model\UserProduct;
use Request\RequestOrder;
use Service\OrderService;

class OrderController
{
    private AuthenticationInterface $authenticationService;
    private OrderService $orderService;

    private ViewRenderer $viewRenderer;
    public function __construct(AuthenticationInterface $authenticationService, OrderService $orderService, ViewRenderer $viewRenderer)
    {
        $this->authenticationService = $authenticationService;
        $this->orderService = $orderService;
        $this->viewRenderer=$viewRenderer;
    }

    public function getOrder():string
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

        return $this->viewRenderer->render('get_order.phtml', [
            'products' => $products,
            'userId' => $userId,
            'user' => $user,
            'userProducts' => $userProducts
        ]);
    }

    public function postOrder(RequestOrder $request):string
    {

        $errors = [];

        $errors = $request->validate($_POST);

        if (!$this->authenticationService->check()) {
            header('location: /login');
        }

        $user = $this->authenticationService->getCurrentUser();

        if(!$user) {
            header('location: /login');
        }

        $name = $request->getName();
        $email = $request->getEmail();
        $phone = $request->getPhone();
        $address = $request->getAddress();
        $comment = $request->getComment();

        $userId = $user->getId();


        if (empty($errors)) {
            $this->orderService->create($userId, $name, $email, $phone, $address, $comment);

            header('Location: /catalog');

        } else {
            $products = Product::getAllByUserId($userId);
            $userProducts = UserProduct::getCartByUserId($userId);
        }

        return $this->viewRenderer->render('get_order.phtml', []);
    }
}