<?php 

namespace KpTest\Validation;

use KpTest\Interfaces\RuleInterface;

/**
 * UndefinedRule class
 * Elements' values must match
 */
class UndefinedRule implements RuleInterface {


    // Validate
    public function isValid($value){

        return false;
        
    }
}
 