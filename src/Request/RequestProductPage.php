<?php

namespace Request;

use Core\src\Request\Request;

class RequestProductPage extends Request
{
    public function getProductId(): string
    {
        return $this->body['product_id'];
    }

    public function getFile(): string
    {
        return $this->body['up'];
    }
}