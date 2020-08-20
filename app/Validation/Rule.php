<?php 

namespace KpTest\Validation;
use KpTest\Exceptions\RuleNotDefinedException;

/**
 * Rule class
 * Creates A Validation Rule Object Based On Rule Name
 */
class Rule {

    // Validate
    public function create($class){
    	if (class_exists($class)) {
    		return new $class();
    	} else {
    		throw new RuleNotDefinedException();
    	}
        
    }

}
 