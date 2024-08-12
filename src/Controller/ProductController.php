<?php

namespace Controller;

use Core\src\AuthenticationInterface;
use Core\src\ViewRenderer;
use Model\CommentProduct;
use Model\Favorite;
use Model\Product;
use Model\UserProduct;
use Request\RequestComment;
use Request\RequestPlusMinus;
use Request\RequestProductPage;
use Service\CartService;
use Service\CommentFileService;

class ProductController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;

    private CommentFileService $commentFileService;
    private ViewRenderer $viewRenderer;
    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService,
                                CommentFileService $commentFileService, ViewRenderer $viewRenderer)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->viewRenderer = $viewRenderer;
        $this->commentFileService = $commentFileService;

    }
    public function getProducts():string
    {
        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }
        $user = $this->authenticationService->getCurrentUser();

        if (!$user) {
            header('Location: /login');
        }
        $userId = $user->getId();
        $products = Product::getAll();

        $count = UserProduct::getCount($userId);

        $countFavorite = Favorite::getCount($userId);


        return $this->viewRenderer->render('get_catalog.phtml', [
            'products' => $products,
            'count' => $count,
            'countFavorite' => $countFavorite
        ]);

    }
    public function plusProduct(RequestPlusMinus $request): void
    {

        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }

        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();
        $this->cartService->plus($userId, $productId);
        header('location: /catalog' );

    }

    public function minusProduct(RequestPlusMinus $request): void
    {

        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }

        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();


        $this->cartService->minus($userId, $productId);
        header('location: /catalog' );

    }

    public function pageProduct(RequestProductPage $request):string
    {
        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }
        $user = $this->authenticationService->getCurrentUser();

        if (!$user) {
            header('Location: /login');
        }

        //$userId = $user->getId();

        $productId = $request->getProductId();

        $product = Product::getOne($productId);

        $commentsProduct = CommentProduct::getByProductId($productId);

        return $this->viewRenderer->render('get_product.phtml', [
            'product' => $product,
            'commentsProduct' => $commentsProduct
        ]);
    }

    public function postComment(RequestComment $request)
    {
        if (!$this->authenticationService->check()) {

            header('Location: /login');

        }
        $user = $this->authenticationService->getCurrentUser();

        if (!$user) {
            header('Location: /login');
        }

        $comment = $request->getComment();
        $productId = $request->getProductId();
        $file = $request->getFile();
        $fileName = $file['name'];

        $userId = $user->getId();

        if ($comment) {
            CommentProduct::create($userId, $productId, $comment, $fileName);
            $this->commentFileService->create($file);
        }

        header('location: /catalog' );
    }

}