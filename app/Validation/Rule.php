<?php 

namespace KpTest\Validation;

/**
 * Rule class
 * Creates A Validation Rule Object Based On Rule Name
 */
class Rule {


    // Validate
    public function create($class,$value){

        return new $class();
        
    }

}
 