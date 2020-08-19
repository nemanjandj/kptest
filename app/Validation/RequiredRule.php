<?php 

namespace KpTest\Validation;

use KpTest\Interfaces\RuleInterface;

/**
 * RequiredRule class
 * Element can not be empty
 */
class RequiredRule implements RuleInterface {


    // Validate
    public function isValid($value){

        return (!empty(trim($value)));
        
    }
}
 