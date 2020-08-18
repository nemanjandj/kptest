<?php 

namespace KpTest\General;

/**
 * Email class
 */
class Email{

	// Email sending function
    public static function send($to,$subject,$message,$from,$cc=null,$bcc=null){

		// Content-type header
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		// Additional headers
		$headers[] = 'To: '.$to;
		$headers[] = 'From: '.$from;
		if ($cc) $headers[] = 'Cc: '.$cc;
		if ($bcc) $headers[] = 'Bcc: '.$bcc;

		// Send
		mail($to, $subject, $message, implode("\r\n", $headers));
        
    }
}
 