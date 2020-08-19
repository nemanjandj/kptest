<?php

namespace KpTest\Interfaces;

interface ValidatorInterface {

	function setRule($key,$rule);
	function validateForm();
	function validateField($rule,$key);
	function getErrors();
	function addError($error);

}