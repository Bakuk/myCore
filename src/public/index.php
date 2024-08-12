<?php



use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

use Request\RequestLogin;
use Request\RequestPlusMinus;
use Request\RequestRegistrate;


use bakuk\onlineShop\App;
use bakuk\OnlineShop\Container\Container;

require_once './../vendor/autoload.php';

$services = include './../Config/Services.phtml';

$container = new Container($services);

$app = new App($container);

$app->getRoutes('/registrate', UserController::class, 'getRegistrate');
$app->postRoutes('/registrate', UserController::class, 'postRegistrate', RequestRegistrate::class);

$app->getRoutes('/login', UserController::class, 'getLogin');
$app->postRoutes('/login', UserController::class, 'postLogin', RequestLogin::class);

$app->getRoutes('/catalog', ProductController::class, 'getProducts');
$app->getRoutes('/cart', CartController::class, 'getCart');

$app->getRoutes('/favorite', FavoriteController::class, 'getFavoriteProduct');
$app->postRoutes('/favorite', FavoriteController::class, 'addProduct', \Request\RequestFavorite::class);

$app->getRoutes('/order', OrderController::class, 'getOrder');
$app->postRoutes('/order', OrderController::class, 'postOrder', \Request\RequestOrder::class);

$app->postRoutes('/minus', ProductController::class, 'minusProduct', RequestPlusMinus::class);
$app->postRoutes('/plus', ProductController::class, 'plusProduct', RequestPlusMinus::class);

$app->getRoutes('/logout', UserController::class, 'logout');
$app->getRoutes('/api/users', \Controller\API\UserController::class, 'index');

$app->postRoutes('/product', ProductController::class, 'pageProduct', \Request\RequestProductPage::class);

$app->postRoutes('/comment', ProductController::class, 'postComment', \Request\RequestComment::class);


$app->run();