<?php

namespace KpTest\Interfaces;

interface Observer {

	function onUserRegistered( $observable, $data );

}