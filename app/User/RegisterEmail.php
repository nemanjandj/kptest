<?php 

namespace KpTest\User;

use KpTest\Interfaces\Observer;
use KpTest\General\Email;

/**
 * RegisterEmail class
 * Observes user registration
 */
class RegisterEmail extends Email implements Observer {
	private $from = 'adm@kupujemprodajem.com';
	private $subject = 'Dobro došli';
	private $message = 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu...';

	// Send registration email
    public function  onUserRegistered($observable, $data) 
    {
        $this->send($data['email'],$this->subject,$this->message,$this->from);
    }
}
 