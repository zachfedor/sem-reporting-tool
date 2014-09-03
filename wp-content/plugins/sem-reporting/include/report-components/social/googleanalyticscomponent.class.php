<?php

class GoogleAnalyticsComponent extends SimpleComponent
{
	protected $total_sessions, $sessions_social_referral;
	
	function __construct( $total_sessions=0, $sessions_social_referral=0 )
	{
		$this->total_sessions = $total_sessions;
		$this->sessions_social_referral = $sessions_social_referral;
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		return new self( $arr['total_sessions'], $arr['sessions_social_referral'] );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-google-analytics-component">
			Total Sessions: <?php echo $this->total_sessions; ?><br />
			Sessions Via Social Referral: <?php echo $this->sessions_social_referral; ?>
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
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