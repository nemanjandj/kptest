<?php

use PHPUnit\Framework\TestCase;
use KpTest\Validation\Validator;
use KpTest\Interfaces\ValidatorInterface;
use KpTest\Exceptions\RuleNotDefinedException;

/**
 * ValidatorTest Class
 */
class ValidatorTest extends TestCase
{

	private $request;


	// Test if Validator object can be created
	public function testValidatorCreation () {

		$validator = new Validator($this->request);
		$this->assertIsObject($validator);

	}


	// Test setRule and ruleExistForKey functions by adding rule and checking if existing in array of rules
	public function testSettingRule() {

		$validator = new Validator($this->request);
		$key = 'email';
		$rule = 'required';
		$validator->setRule($key, $rule, 'Email Field Is Required');
		$ruleExists = $validator->ruleExistForKey($key, $rule);

		$this->assertTrue($ruleExists);

	}



	// Test Required Rule by passing empty and not empty strings
	public function testRequiredRule() {

		$rule = 'required';

		$key1 = 'first_name'; 
		$value1 = 'Nemanja';
		$msg1 = 'First Name is Required';

		$key2 = 'last_name';
		$value2 = '';
		$msg2 = 'Last Name is Required';

		$this->request = [
			$key1 => $value1,
			$key2 => $value2
		];

		$validator = new Validator($this->request);		
		$validator->setRule($key1, $rule, $msg1);
		$validator->setRule($key2, $rule, $msg2);
		$validator->validateForm();

		$errors = $validator->getErrors();

		$this->assertNotContains(['name' => $key1, 'message' => $msg1], $errors);
		// first_name has value 'Nemanja' and is not in the errors list

		$this->assertContains(['name' => $key2, 'message' => $msg2], $errors);
		// last_name has empty value and it should in the errors list

	}



	// Test Email Format Rule by passing values that fit and doesn't fit email format
	public function testEmailFormatRule() {

		$rule = 'email';

		$key1 = 'email1'; 
		$value1 = 'nemanjandj@gmail.com'; // valid email format
		$msg1 = 'Email Must Be Valid Format';

		$key2 = 'email2';
		$value2 = 'Nemanja'; // invalid email format
		$msg2 = 'Email Must Be Valid Format';

		$this->request = [
			$key1 => $value1,
			$key2 => $value2
		];

		$validator = new Validator($this->request);		
		$validator->setRule($key1, $rule, $msg1);
		$validator->setRule($key2, $rule, $msg2);
		$validator->validateForm();

		$errors = $validator->getErrors();
		
		$this->assertNotContains(['name' => $key1, 'message' => $msg1], $errors); 
		// First email should not be in the errors array because it has valid email format

		$this->assertContains(['name' => $key2, 'message' => $msg2], $errors); 
		// Second email is not valid email format, so it should appear in the errors array

	}



	// Test Minimum Rule by passing values smaller and bigger (or equal) than minimum value
	public function testMinimumRule() {

		$rule = 'min=7';

		$key1 = 'first_name'; 
		$value1 = 'Nemanja'; // Valid since length is 7
		$msg1 = 'First name must have minimum 7 letters';

		$key2 = 'last_name';
		$value2 = 'Djoric'; // Not valid, length is 6
		$msg2 = 'Last name must have minimum 7 letters';

		$this->request = [
			$key1 => $value1,
			$key2 => $value2
		];

		$validator = new Validator($this->request);		
		$validator->setRule($key1, $rule, $msg1);
		$validator->setRule($key2, $rule, $msg2);
		$validator->validateForm();

		$errors = $validator->getErrors();

		$this->assertNotContains(['name' => $key1, 'message' => $msg1], $errors); 
		// first_name has length greater than 7 and is not in the errors list

		$this->assertContains(['name' => $key2, 'message' => $msg2], $errors); 
		// last_name has length smaller than 7 and it should be in the errors list
	}




	// Test Confirm Value Rule by passing unique values in first scenarion and diffrerent values in second scenario
	public function testConfirmRule() {

		// 
		$rule = 'confirm:password';

		$key1 = 'password'; 
		$value1 = 'nemanja123';

		$key2 = 'password2';
		$value2 = 'nemanja123'; // password is the same
		
		$key3 = 'password3';
		$value3 = 'nemanja123456'; // password different
		
		$msg = 'Password Must Be Confirmed';

		$this->request = [
			$key1 => $value1,
			$key2 => $value2,
			$key3 => $value3
		];

		$validator = new Validator($this->request);
		$validator->setRule($key2, $rule, $msg);
		$validator->setRule($key3, $rule, $msg);
		$validator->validateForm();

		$errors = $validator->getErrors();

		$this->assertNotContains(['name' => $key2, 'message' => $msg], $errors); 
		// error is not in the array since values are equal

 		$this->assertContains(['name' => $key3, 'message' => $msg], $errors); 
 		// error is in the array since values are not equal

	}




	// Test if errors array empty if valdation passes
	public function testValidationPasses() {

		//required
		$rule1 = 'required';
		$key1 = 'first_name'; 
		$value1 = 'Nemanja'; // Not empty
		$msg1 = 'First Name is Required';

		// Email
		$rule2 = 'email';
		$key2 = 'email1'; 
		$value2 = 'nemanjandj@gmail.com'; // valid email format
		$msg2 = 'Email Must Be Valid Format';

		// Minimum
		$rule3 = 'min=5';
		$key3 = 'first_name'; 
		$value3 = 'Nemanja'; // Valid since length is 7
		$msg3 = 'First name must have minimum 5 letters';

		// Confirm

		$rule4 = 'confirm:first_name';
		$key4 = 'first_name_confirm'; 
		$value4 = 'Nemanja'; // Same value as first_name
		$msg4 = 'First Name is not Confirmed';

		$this->request = [
			$key1 => $value1,
			$key2 => $value2,
			$key3 => $value3,
			$key4 => $value4
		];

		$validator = new Validator($this->request);
		$validator->setRule($key1, $rule1, $msg1);
		$validator->setRule($key2, $rule2, $msg2);
		$validator->setRule($key3, $rule3, $msg3);
		$validator->setRule($key4, $rule4, $msg4);
		$validator->validateForm();


		$errors = $validator->getErrors();
		$this->assertEmpty($errors);
		// All validation methods passess and errors array is empty

	}



	// Test If Rule Not Set
	public function testUndefinedRule() {

		$this->expectException(RuleNotDefinedException::class); 
		// If this test passes, it means that rule is not defined and we get Exceptrion,
		// so we need to create another class for this rule.

		$rule = '123!@#!@#';

		$key = 'first_name'; 
		$value = 'Nemanja';
		$msg = 'Undefined Error';

		$this->request = [$key => $value];
		$validator = new Validator($this->request);
		$validator->setRule($key, $rule, $msg);		
		$validator->validateForm();
		
		$errors = $validator->getErrors();

	}





}