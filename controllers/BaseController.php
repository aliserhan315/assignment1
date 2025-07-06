<?php

require_once __DIR__ . '/../services/ResponseService.php';

class BaseController {
    protected $responseService;

    public function __construct() {
        $this->responseService = new ResponseService();
    }
      public function success_response($data) {
        return $this->responseService->success_response($data);
    }

    public function error_response($message) {
        return $this->responseService->error_response($message);
    }
}
