<?php 

namespace KpTest\Validation;

use KpTest\Interfaces\RuleInterface;

/**
 * MinRule class
 * Value length must be bigger or equal than minumum
 */
class MinRule implements RuleInterface {


    // Validate
    public function isValid($value){

        return (strlen(trim($value['value'])) >= $value['min']);
        
    }
}
 