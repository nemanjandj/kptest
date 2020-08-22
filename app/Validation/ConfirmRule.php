<?php 

namespace KpTest\Validation;

use KpTest\Interfaces\RuleInterface;

/**
 * ConfirmRule class
 * Values must match
 */
class ConfirmRule implements RuleInterface {


    // Validate
    public function isValid($value){

        return ($value['value'] == $value['confirm']);
        
    }
}
 