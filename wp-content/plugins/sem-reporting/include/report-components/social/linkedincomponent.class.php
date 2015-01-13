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
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json );
		
		return self::get_from_array( $arr );
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
		<div id="dv-linked-in-component" class="report-component">
			<h3 class="rc-title rc-full">LinkedIn</h3>

            <div class="rc-content">
                <div class="rc-col rc-col-one">
                    <h5 class="rc-heading">Total Followers</h5>
                    <p class="rc-data"><?php echo $this->total_followers; ?></p>
                    <h5 class="rc-heading">New Followers</h5>
                    <p class="rc-data"><?php echo $this->new_followers; ?></p>
                </div>
                <div class="rc-col rc-col-two">
                    <h5 class="rc-heading">Impressions</h5>
                    <p class="rc-data"><?php echo $this->impressions; ?></p>
                    <h5 class="rc-heading">Engagement Rate</h5>
                    <p class="rc-data"><?php echo $this->engagement_rate * 100; ?>%</p>
                </div>
            </div>
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