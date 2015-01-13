<?php

class CompetitorMentionsComponent extends SimpleComponent
{
	protected $competitor_mentions;
	
	function __construct( $competitor_mentions=array() )
	{
		$this->competitor_mentions = $competitor_mentions;
	}
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json );
		
		return self::get_from_array( $arr );
	}
	
	public static function get_from_array( $arr )
	{
		$competitor_mentions = array();
		foreach( $arr['competitor_mentions'] as $competitor_mention )
		{
			$competitor_mentions[] = new CompetitorMention( $competitor_mention['page_url'], $competitor_mention['date'] );
		}
		
		return new self( $competitor_mentions );
	}

	public function get_competitor_mentions()
	{
	    return $this->competitor_mentions;
	}
}