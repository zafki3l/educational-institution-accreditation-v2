<?php

namespace App\Shared\Web\Responses;

use Core\Response;

class ViewResponse extends Response
{
    public function __construct(
        public string $module, 
        public string $view, 
        public string $layout, 
        array $data = [])
    {
        $this->module = $module;
        $this->view = $view;
        $this->layout = $layout;
        parent::__construct($data);
    }
}