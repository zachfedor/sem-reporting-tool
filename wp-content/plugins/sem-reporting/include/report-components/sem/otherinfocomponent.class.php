<?php

class OtherInfoComponent extends SimpleComponent
{
	protected $sessions, $pages_per_session, $average_session_duration, $bounce_rate;
	
	function __construct( $sessions=0, $pages_per_session=0, $average_session_duration=0, $bounce_rate=0 )
	{
		$this->sessions = $sessions;
		$this->pages_per_session = $pages_per_session;
		$this->average_session_duration = $average_session_duration;
		$this->bounce_rate = $bounce_rate;
	}
	
	public static function get_by_client( $client )
	{
		return Google::get_sem_other_info_component( $client );
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		return new self( $arr['sessions'], $arr['pages_per_session'], $arr['average_session_duration'], $arr['bounce_rate'] );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-other-info-component">
			Sessions: <?php echo $this->sessions; ?><br />
			Pages / Session: <?php echo $this->pages_per_session; ?><br />
			Avg. Session Duration: <?php echo $this->average_session_duration; ?><br />
			Bounce Rate: <?php echo $this->bounce_rate; ?>%<br />
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
	}

	public function get_sessions()
	{
	    return $this->sessions;
	}

	public function get_pages_per_session()
	{
	    return $this->pages_per_session;
	}

	public function get_average_session_duration()
	{
	    return $this->average_session_duration;
	}

	public function get_bounce_rate()
	{
	    return $this->bounce_rate;
	}
}