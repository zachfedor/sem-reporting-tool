<?php

class GoogleAnalyticsComponent extends SimpleComponent
{
	protected $total_sessions, $sessions_social_referral;
	
	function __construct( $total_sessions=0, $sessions_social_referral=0 )
	{
		$this->total_sessions = $total_sessions;
		$this->sessions_social_referral = $sessions_social_referral;
	}

	public function get_total_sessions()
	{
	    return $this->total_sessions;
	}

	public function get_sessions_social_referral()
	{
	    return $this->sessions_social_referral;
	}
}