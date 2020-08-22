<?php 

namespace KpTest\User;

use KpTest\Interfaces\Subject;
use KpTest\General\Database;
use KpTest\General\ApiResponse;

/**
 * Register class
 * Implements Subject interface that is observed
 */
class RegisterUser implements Subject {

	protected $observers = [];

	public function attach($observer) {
		$this->observers[] = $observer;
	}

	public function notify($data) {
		foreach ($this->observers as $observer) {
			$observer->onUserRegistered($this, $data);
		}
	}

    public function fire($data){

    	// Validate Request data
        $validate = new RegistrationValidator($data);
        $validate->validateRegistrationForm();

        // Get DB instance
        $db = Database::getInstance();

        // Check if user exists
        $userExists = User::userExist($data['email']);
        if ($userExists) {ApiResponse::displayError('email_already_taken');} 

        // Create User in Database
        $email = trim($data['email']);
        $password = $data['password'];
        $query = "INSERT INTO user (email, password) VALUES (?, ?)";
        $userId = $db->insertRow($query,[$email, $password]);

        if ($userId) {
            
            // Notify observers on function success
            $observerData = ['userId'=>$userId,'email'=>$email];
            $this->notify($observerData);
            
            ApiResponse::displaySuccess('userId',$userId);
        } else {
        	ApiResponse::displayError('DB_error');
        }
    	
    }
}
 