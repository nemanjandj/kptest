<?php 

namespace KpTest\User;

use KpTest\Interfaces\Observer;
use KpTest\General\Database;

/**
 * UserLog class
 * Observes user registration
 */
class UserLog implements Observer {


    // Create user register log
    public function onUserRegistered($observable, $data){

    	$userId=$data['userId'];
    	$action = 'register';
    	$time = 'NOW()';
    	$db = Database::getInstance();

    	$query = "INSERT INTO user_log (action, user_id, log_time) VALUES (?, ?, NOW())";
        
        $insert = $db->insertRow($query, [$action, $userId]);

        return $insert ? true : ApiResponse::displayError('DB_error');      
        
    }
}
 