<?php 

namespace KpTest\General;

/**
 * ApiResponse class
 */
class ApiResponse {

    // Error json response
    public static function displayError($error){
        echo json_encode([
           'success' => false,
           'error' => $error
        ]);
        exit;
    }

    // Success json response
    public static function displaySuccess($key,$value){
        echo json_encode([
           'success' => true,
           $key => $value
        ]);
        exit;
    }

}