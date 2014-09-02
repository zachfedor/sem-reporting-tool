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