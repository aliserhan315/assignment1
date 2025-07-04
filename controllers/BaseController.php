<?php

require_once __DIR__ . '/../services/ResponseService.php';

class BaseController {
    protected $responseService;

    public function __construct() {
        $this->responseService = new ResponseService();
    }
}
