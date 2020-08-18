<?php 

namespace KpTest\User;

use KpTest\General\Database;
use KpTest\General\Email;
use KpTest\General\ApiResponse;

/**
 * RegisterUserFactory class
 */
class RegisterUserFactory {

    // Create new user registration, attach observers, and run register method
    public static function create($data)
    {
        $register = new RegisterUser;    
        $register->attach(new RegisterEmail);
        $register->attach(new UserLog);
        $register->attach(new UserSession);
        $userId = $register->fire($data);
    }
}