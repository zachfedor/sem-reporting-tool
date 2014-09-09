<?php

class TwitterComponent extends SimpleComponent
{
	protected $total_followers, $total_following;
	
	function __construct( $total_followers, $total_following )
	{
		$this->total_followers = $total_followers;
		$this->total_following = $total_following;
	}
	
	public static function get_by_client( $client )
	{
		return Twitter::get_component( $client );
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		return new self( $arr['total_followers'], $arr['total_following'] );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-twitter-component">
			<h3>Twitter</h3>
			Total Followers: <?php echo $this->total_followers; ?><br />
			Total Following: <?php echo $this->total_following; ?>
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
	}

	public function get_total_followers()
	{
	    return $this->total_followers;
	}

	public function get_total_following()
	{
	    return $this->total_following;
	}
}