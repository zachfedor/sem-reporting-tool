<?php

set_include_path(
	get_include_path()
	. PATH_SEPARATOR . __DIR__ . '/'
);

require_once 'simplecomponent.class.php';

require_once 'sem/competitorlinkmetricscomponent.class.php';
require_once 'sem/competitormentionscomponent.class.php';
require_once 'sem/domainauthoritycomponent.class.php';
require_once 'sem/otherinfocomponent.class.php';
require_once 'sem/rankinghighlightscomponent.class.php';
require_once 'sem/visitscomponent.class.php';

require_once 'sem/helper-classes/competitorlinkmetric.class.php';
require_once 'sem/helper-classes/competitormention.class.php';
require_once 'sem/helper-classes/domainauthoritycompetitor.class.php';
require_once 'sem/helper-classes/infopiece.class.php';
require_once 'sem/helper-classes/keyword.class.php';
require_once 'sem/helper-classes/visit.class.php';

require_once 'social/googleanalyticscomponent.class.php';
require_once 'social/facebookcomponent.class.php';
require_once 'social/twittercomponent.class.php';
require_once 'social/youtubecomponent.class.php';
require_once 'social/pinterestcomponent.class.php';
require_once 'social/linkedincomponent.class.php';

require_once 'social/helper-classes/facebookpost.class.php';
require_once 'social/helper-classes/youtubedemographics.class.php';