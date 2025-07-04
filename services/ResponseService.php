<?php

class ResponseService {

    public function success_response($data) {
     
        return json_encode([
            "status" => 200,
            "data" => $data
        ]);
       
    }
    public function error_response($message){
        
        return json_encode([
            "status" => 500,
            "message" => $message
        ]);
    }


}