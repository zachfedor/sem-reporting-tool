<?php

class FacebookComponent extends SimpleComponent
{
	protected $total_likes, $total_reach, $top_ten_posts;
	
	function __construct( $total_likes=0, $total_reach=0, $top_ten_posts=array() )
	{
		$this->total_likes = $total_likes;
		$this->total_reach = $total_reach;
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
			$top_ten_posts[] = new FacebookPost( $post['content'] );
		}
		
		return new self( $arr['total_likes'], $arr['total_reach'], $top_ten_posts );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-facebook-component">
		
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

	public function get_top_ten_posts()
	{
	    return $this->top_ten_posts;
	}
}