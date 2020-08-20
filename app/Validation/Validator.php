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
    public function setRule($key,$rule,$msg){
        $ruleExists = $this->ruleExistForKey($key,$rule);
        if (!$ruleExists) 
            $this->rules[$key][]=['rule' => $rule, 'msg' => $msg];
    }

    // Validate Form
    public function validateForm(){
        if (is_array($this->data)) {
            foreach ($this->data as $key => $value) {
                if (array_key_exists($key,$this->rules)) {
                    $valRules=$this->rules[$key];
                    foreach ($valRules as $rule) {
                        $this->validateField($rule,$key);
                    }
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
        if (strpos($rule['rule'],'=') !== false) {
            $rules = explode('=',$rule['rule']);
            $ruleType = $rules[0];
            $ruleVal = $rules[1];
            $data = ['value' => $this->data[$key], 'min' => $ruleVal];
        } elseif (strpos($rule['rule'],':') !== false) {
            $rules = explode(':',$rule['rule']);
            $ruleType = $rules[0];
            $ruleVal = $rules[1];
            $data = ['value' => $this->data[$key], 'confirm' => $this->data[$ruleVal]];
        } else {
            $ruleType = $rule['rule'];
            $data = $this->data[$key];
        }
        $msg=$rule['msg'];

        $rule = new Rule();
        $className = __NAMESPACE__.'\\'.ucfirst($ruleType).'Rule';
        $rule = $rule->create($className);
        $rule->isValid($data) ? true : $this->addError($key,$msg);
    }

    // Add validation error to the array
    public function addError($key,$error){
        $this->errors[]=['name' => $key, 'message' => $error];
    }

    // Get array of rules for the key
    public function getRules($key) {
        return (array_key_exists($key, $this->rules)) ? $this->rules[$key] : [];
    }

    public function ruleExistForKey($key,$rule) {
        $keyRules = $this->getRules($key);
        foreach ($keyRules as $keyRule) {
            if ($keyRule['rule'] == $rule) {
                return true;
            }
        }
        return false;
    }

}