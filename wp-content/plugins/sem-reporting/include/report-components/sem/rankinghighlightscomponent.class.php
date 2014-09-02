<?php

class RankingHighlightsComponent extends SimpleComponent
{
	protected $keywords;
	
	function __construct( $keywords=array() )
	{
		$this->keywords = $keywords;
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		$keywords = array();
		foreach( $arr['keywords'] as $keyword )
		{
			$keywords[] = new Keyword( $keyword['keyword'], $keyword['from'], $keyword['to'] );
		}
		
		return new self( $keywords );
	}

	public function get_keywords()
	{
	    return $this->keywords;
	}
}