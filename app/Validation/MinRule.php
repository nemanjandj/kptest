<?php 

namespace KpTest\Validation;

use KpTest\Interfaces\RuleInterface;

/**
 * MinRule class
 * Element must have value greater thant minumum
 */
class MinRule implements RuleInterface {


    // Validate
    public function isValid($value){

        return (strlen(trim($value['value'])) >= $value['min']);
        
    }
}
 