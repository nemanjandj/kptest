<?php 

namespace KpTest\Validation;

use KpTest\Interfaces\ValidatorInterface;

/**
 * Validator class
 */
class Validator implements ValidatorInterface {
    private $data;
    protected $errors = [];
    protected $rules = [];


    public function __construct ($postData){
        $this->data = $postData;
    }

    // Add Validation Rule For Specific Key
    public function setRule($key,$rule){
        if (array_key_exists($key, $this->rules)) {
            if (!in_array($rule, $this->rules[$key])) {
                $this->rules[$key][]=$rule;
            }
        } else {
            $this->rules[$key][] = $rule;
        }
    }

    // Validate Form
    public function validateForm(){
        foreach ($this->data as $key => $value) {
            if (array_key_exists($key,$this->rules)) {
                $valRules=$this->rules[$key];
                foreach ($valRules as $rule) {
                    $this->validateField($rule,$key);
                }
            }
        }
        return $this->errors;
    }

    // Return Validation Errors
    public function getErrors() {
        return $this->errors;
    }

    // Validate input field with selected rule
    public function validateField($rule,$key) {
        if (strpos($rule,':') !== false) {
            $rules = explode(':',$rule);
            $ruleType = $rules[0];
            $ruleVal = $rules[1];
        } else {
            $ruleType = $rule;
        }


        switch ($ruleType) {
            case 'email':
                $data = $this->data[$key];
                $error = 'email_format';
                break;
            case 'min':
                $data = ['value' => $this->data[$key], 'min' => $ruleVal];
                $error = $key;
                break;
            case 'confirm':
                $data = ['value' => $this->data[$key], 'confirm' => $this->data[$ruleVal]];
                $error = $ruleVal.'_mismatch';
                break;
            default: 
                $data = $this->data[$key];
                $error = $key;
                break;
        }

        $rule = new Rule();
        $className = __NAMESPACE__.'\\'.ucfirst($ruleType).'Rule';
        $rule = $rule->create($className, $data);
        $rule->isValid($data) ? true : $this->addError($error);
    }

    // Add validation error to the array
    public function addError($error){
        $this->errors[]=$error;
    }

}