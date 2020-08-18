<?php 

namespace KpTest\General;

/**
 * Validator class
 */
class Validator {
    private $data;
    protected $errors=[];
    protected $rules = [];


    public function __construct ($postData){
        $this->data = $postData;
    }

    // Validate Form
    public function validateForm(){
        foreach ($this->data as $key => $value) {
            if (array_key_exists($key,$this->rules)) {
                $valRules=explode('|',$this->rules[$key]);
                foreach ($valRules as $rule) {
                    $this->validateField($rule,$key);
                }
            }
        }
        return $this->errors;
    }

    // Validate input field with selected rule
    public function validateField($rule,$key) {
        if (strpos($rule,':')!==false) {
            $rules = explode(':',$rule);
            $ruleType = $rules[0];
            $ruleVal = $rules[1];
        } else {
            $ruleType = $rule;
        }

        switch ($ruleType) {
            case 'required':
                $this->required($key); break;
            case 'email':
                $this->emailFormat($key); break;
            case 'min':
                $this->minCharacters($key,$ruleVal); break;
            case 'confirm':
                $this->confirmValue($key,$ruleVal); break;
            default:
                return false; break;
        }
    }

    // Required input (not empty string)
    public function required($key){
        empty(trim($this->data[$key])) ? $this->addError($key, 'required') : false;
    }

    // Valid email format
    public function emailFormat($key){
        !filter_var(trim($this->data[$key]), FILTER_VALIDATE_EMAIL) ? $this->addError($key, 'email') : false;
    }

    // Minimum characters
    public function minCharacters($key,$min){
        strlen(trim($this->data[$key])) < $min ? $this->addError($key, 'min') : false;
    }

    // Confirms selected input
    public function confirmValue($key,$key2){
        trim($this->data[$key]) != trim($this->data[$key2]) ? $this->addError($key, 'confirm') : false;
    }

    // Add validation error to the array
    public function addError($key, $rule){
        $this->errors[]=['key' => $key, 'rule' => $rule];
    }

}