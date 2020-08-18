<?php

namespace KpTest\Interfaces;

interface Subject {
	function attach( $observer );
	function notify($data);
}