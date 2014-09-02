<?php

class PinterestComponent extends SimpleComponent
{
	protected $pins_from_website, $imporessions, $reach, $clicks;
	
	function __construct( $pins_from_website=0, $impressions=0, $reach=0, $clicks=0 )
	{
		$this->pins_from_website = $pins_from_website;
		$this->impressions = $impressions;
		$this->reach = $reach;
		$this->clicks = $clicks;
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		return new self( $arr['pins_from_website'], $arr['impressions'], $arr['reach'], $arr['clicks'] );
	}

	public function get_pins_from_website()
	{
	    return $this->pins_from_website;
	}

	public function get_imporessions()
	{
	    return $this->imporessions;
	}

	public function get_reach()
	{
	    return $this->reach;
	}

	public function get_clicks()
	{
	    return $this->clicks;
	}
}