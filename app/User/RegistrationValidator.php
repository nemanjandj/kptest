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
        $validator->setRule('email','required','email');
        $validator->setRule('email','email','email_format');
        $validator->setRule('password','required','password');
        $validator->setRule('password','min:8','password');
        $validator->setRule('password2','required','password2');
        $validator->setRule('password2','min:8','password2');
        $validator->setRule('password2','confirm:password','password_mismatch');
        $validator->validateForm();

        $errors = $validator->getErrors();

        if (!empty($errors)) ApiResponse::displayError($errors[0]['message']);
    }
}