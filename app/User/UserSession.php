<?php 

namespace KpTest\User;

use KpTest\Interfaces\Observer;

/**
 * Log class
 * Observes user registration
 */
class UserSession implements Observer {

	// Add user ID to the session
    public function onUserRegistered($observable, $data){

    	$_SESSION['userId']=$data['userId'];
    	return true;
        
    }
}
 