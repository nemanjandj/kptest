<?php 

namespace KpTest\Validation;

use KpTest\Interfaces\RuleInterface;

/**
 * EmailRule class
 * Value must have valid email format
 */
class EmailRule implements RuleInterface {


    // Validate
    public function isValid($value){

        return (filter_var(trim($value), FILTER_VALIDATE_EMAIL));
        
    }
}
 