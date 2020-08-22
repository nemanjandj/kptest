<?php 

namespace KpTest\Exceptions;

/**
 * RuleNotDefinedException class for validation rules that are not defined
 */
class RuleNotDefinedException extends \Exception
{

    protected $message = 'This validation rule is not defined!';
    protected $code = 1;
    protected $previous = null;

    public function __construct() {

        parent::__construct($this->message, $this->code, $this->previous);

    }

}