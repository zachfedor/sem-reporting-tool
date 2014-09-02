<?php

set_include_path(
	get_include_path()
	. PATH_SEPARATOR . __DIR__ . '/'
);

require_once 'facebook.class.php';
require_once 'twitter.class.php';
require_once 'google.class.php';
require_once 'moz.class.php';