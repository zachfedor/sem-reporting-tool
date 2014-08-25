<?php

set_include_path(
	get_include_path()
	. PATH_SEPARATOR . __DIR__ . '/'
);

require_once 'simplereporting.class.php';
require_once 'simplecomponent.class.php';
require_once 'competitorlinkmetricscomponent.class.php';
require_once 'competitormentionscomponent.class.php';
require_once 'domainauthoritycomponent.class.php';
require_once 'otherinfocomponent.class.php';
require_once 'rankinghighlightscomponent.class.php';
require_once 'visitscomponent.class.php';

require_once 'helper-classes/simplehelper.class.php';
require_once 'helper-classes/competitorlinkmetric.class.php';
require_once 'helper-classes/competitormention.class.php';
require_once 'helper-classes/domainauthoritycompetitor.class.php';
require_once 'helper-classes/infopiece.class.php';
require_once 'helper-classes/keyword.class.php';
require_once 'helper-classes/visit.class.php';