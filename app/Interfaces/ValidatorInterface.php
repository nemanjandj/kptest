<?php

namespace KpTest\Interfaces;

interface ValidatorInterface {

	function setRule($key,$rule,$msg);
	function validateForm();
	function validateField($rule,$key);
	function getErrors();
	function addError($key,$error);

}