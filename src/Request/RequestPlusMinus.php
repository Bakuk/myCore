<?php

namespace Request;

use Core\src\Request\Request;

class RequestPlusMinus extends Request
{
    public function getProductId(): string
    {
        return $this->body['product_id'];
    }

}