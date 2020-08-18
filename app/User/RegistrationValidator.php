<?php 

namespace KpTest\User;

use KpTest\General\ApiResponse;
use KpTest\General\Validator;
/**
 * RegistrationValidator class
 */
class RegistrationValidator extends Validator {

    // Validation Rules
    protected $rules = [
        'email'     =>  'required|email',
        'password'  =>  'required|min:8',
        'password2' =>  'required|min:8|confirm:password'
    ];

    // Validation Order
    protected $errorResponses=[
        ['input'=>'email', 'rule'=>'required', 'message'=>'email'],
        ['input'=>'email', 'rule'=>'email', 'message'=>'email_format'],
        ['input'=>'password', 'rule'=>'required', 'message'=>'password'],
        ['input'=>'password', 'rule'=>'min', 'message'=>'password'],
        ['input'=>'password2', 'rule'=>'required', 'message'=>'password2'],
        ['input'=>'password2', 'rule'=>'min', 'message'=>'password2'],
        ['input'=>'password2', 'rule'=>'confirm', 'message'=>'password_mismatch'],
    ];

    // Validate Form - Validates all errors and returns first if exists
    public function validateRegistrationForm() {

        // Validates form with parent class
        $errors = $this->validateForm();
        
        // Loop through the rules and check if existing in validation response
        foreach ($this->errorResponses as $response) {
            if (in_array(['key'=>$response['input'],'rule' => $response['rule']],$errors)) {
                ApiResponse::displayError($response['message']);
            }
        }
    }
}