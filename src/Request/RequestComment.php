<?php

namespace Request;

use Core\src\Request\Request;

class RequestComment extends Request
{
    public function getProductId(): string
    {
        return $this->body['product_id'];
    }
    public function getComment(): string
    {
        return $this->body['comment'];
    }

    public function getFile(): array
    {
        return $_FILES['upfile'];
    }

}