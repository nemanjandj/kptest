<?php 

namespace KpTest\User;

use KpTest\General\Database;
use KpTest\General\Email;
use KpTest\General\ApiResponse;

/**
 * User class
 */
class User {

    // Check if user exists, returns Id or false
    public static function userExist($email){

        $db = Database::getInstance();
        $query = "SELECT id FROM user WHERE email = ?";

        $user = $db->selectRow($query,$email);
        
        return $user ?: false;
    }
}





    