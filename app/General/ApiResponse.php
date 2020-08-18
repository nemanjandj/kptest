<?php 

namespace KpTest\General;

/**
 * ApiResponse class
 */
class ApiResponse {


    public static function displayError($error){
        echo json_encode([
           'success' => false,
           'error' => $error
        ]);
        exit;
    }

    public static function displaySuccess($key,$value){
        echo json_encode([
           'success' => true,
           $key => $value
        ]);
        exit;
    }

}