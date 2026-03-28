<?php

namespace App\Shared\Web\Responses;

use Core\Response;

class JsonResponse extends Response
{
    public function __construct(
        array $data = [],
        public int $status = 200
    ) {
        parent::__construct($data);
        $this->status = $status;
    }

    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}