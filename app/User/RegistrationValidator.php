<?php 

namespace KpTest\User;

use KpTest\General\ApiResponse;
use KpTest\Validation\Validator;

/**
 * RegistrationValidator class
 */
class RegistrationValidator {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }
  
    // Validate Form - Validates all errors and returns first if exists
    public function validateRegistrationForm() {

        $validator = new Validator($this->data);
        $validator->setRule('email','required');
        $validator->setRule('email','email');
        $validator->setRule('password','required');
        $validator->setRule('password','min:8');
        $validator->setRule('password2','required');
        $validator->setRule('password2','min:8');
        $validator->setRule('password2','confirm:password');
        $validator->validateForm();

        $errors = $validator->getErrors();

        if (!empty($errors)) ApiResponse::displayError($errors[0]);
    }
}