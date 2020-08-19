<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$_REQUEST=[
	'email'		=>	'nemanjandj@gmail.com',
	'password'	=>	'nemanja123',
	'password2'	=>	'nemanja123',
];

session_start();
require "vendor/autoload.php";

use KpTest\User\RegisterUserFactory;

$user = RegisterUserFactory::create($_REQUEST);
