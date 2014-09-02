<?php

class LinkMetric extends SimpleComponent
{
	protected $name, $value;
	
	function __construct( $name='', $value='' )
	{
		$this->name = $name;
		$this->value = $value;
	}

	public function get_name()
	{
	    return $this->name;
	}

	public function get_value()
	{
	    return $this->value;
	}
}