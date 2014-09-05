<?php

class FacebookComponent extends SimpleComponent
{
	protected $total_likes, $total_reach, $reach_breakdown, $top_ten_posts;
	
	function __construct( $total_likes=0, $total_reach=0, $reach_breakdown=array(), $top_ten_posts=array() )
	{
		$this->total_likes = $total_likes;
		$this->total_reach = $total_reach;
		$this->reach_breakdown = $reach_breakdown;
		$this->top_ten_posts = $top_ten_posts;
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		$top_ten_posts = array();
		foreach( $arr['top_ten_posts'] as $post )
		{
			$top_ten_posts[] = new FacebookPost( $post['content'], $post['engagement'], $post['reach ']);
		}
		
		return new self( $arr['total_likes'], $arr['total_reach'], $arr['reach_breakdown'], $top_ten_posts );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-facebook-component">
			Total Likes: <?php echo $this->total_likes; ?><br />
			Total Reach: <?php echo $this->total_reach; ?><br />
			Reach Breakdown:<br />
			<table id="tbl-competitor-lik-metrics">
				<thead>
			        <tr>
			        	<th>Times Seen</th>
			        	<th># People</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php foreach ( $this->reach_breakdown as $times_seen => $num_people ) { ?>
			        <tr>
			            <td><?php echo $times_seen; ?></td>
			            <td><?php echo $num_people; ?></td>
			        </tr>
			        <?php } ?>
			    </tbody>
			</table>
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
	}

	public function get_total_likes()
	{
	    return $this->total_likes;
	}

	public function get_total_reach()
	{
	    return $this->total_reach;
	}

	public function get_reach_breakdown()
	{
	    return $this->reach_breakdown;
	}

	public function get_top_ten_posts()
	{
	    return $this->top_ten_posts;
	}
}