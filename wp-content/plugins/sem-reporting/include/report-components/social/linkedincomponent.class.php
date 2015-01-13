<?php

class LinkedInComponent extends SimpleComponent
{
	protected $total_followers, $new_followers, $impressions, $engagement_rate, $post_stats;
	
	function __construct( $total_followers=0, $new_followers=0, $impressions=0, $engagement_rate=0, $post_stats=array() )
	{
		$this->total_followers = $total_followers;
		$this->new_followers = $new_followers;
		$this->impressions = $impressions;
		$this->engagement_rate = $engagement_rate;
		$this->post_stats = $post_stats;
	}
	
	public static function get_by_client( $client )
	{
		return LinkedInAnalytics::get_component( $client );
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		$post_stats = array();
		foreach( $arr['post_stats'] as $post_stat )
		{
			$post_stats[] = new LinkedInPostStats( $post_stat['content'], $post_stat['post_date'], $post_stat['audience']
				, $post_stat['sponsored'], $post_stat['impressions'], $post_stat['clicks'], $post_stat['interactions']
				, $post_stat['followers_acquired'], $post_stat['engagement_rate'] );
		}
		
		return new self( $arr['total_followers'], $arr['new_followers'], $arr['impressions'], $arr['engagement_rate'], $post_stats );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-linked-in-component">
			<h3>LinkedIn</h3>
			Total Followers: <?php echo $this->total_followers; ?><br />
			New Followers: <?php echo $this->new_followers; ?><br />
			Impressions: <?php echo $this->impressions; ?><br />
			Engagement Rate: <?php echo $this->engagement_rate * 100; ?>%<br />
			Post Statistics:<br />
			POST STATS HERE
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
	}

	public function get_total_followers()
	{
	    return $this->total_followers;
	}

	public function get_new_followers()
	{
	    return $this->new_followers;
	}

	public function get_impressions()
	{
	    return $this->impressions;
	}

	public function get_engagement_rate()
	{
	    return $this->engagement_rate;
	}

	public function get_post_stats()
	{
	    return $this->post_stats;
	}
}