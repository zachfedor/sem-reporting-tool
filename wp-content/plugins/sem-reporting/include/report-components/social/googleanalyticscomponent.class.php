<?php

class GoogleAnalyticsComponent extends SimpleComponent
{
	protected $total_sessions, $sessions_social_referral, $contributed_social_conversions;
	
	function __construct( $total_sessions=0, $sessions_social_referral=0, $contributed_social_conversions=0 )
	{
		$this->total_sessions = $total_sessions;
		$this->sessions_social_referral = $sessions_social_referral;
		$this->contributed_social_conversions = $contributed_social_conversions;
	}
}