<?php

class Visit extends SimpleComponent
{
	protected $type, $num_visits, $percent_change;
	
	function __construct( $type='', $num_visits=0, $percent_change=0 )
	{
		$this->type = $type;
		$this->num_visits = $num_visits;
		$this->percent_change = $percent_change;
	}

	public function get_type()
	{
	    return $this->type;
	}

	public function get_num_visits()
	{
	    return $this->num_visits;
	}

	public function get_percent_change()
	{
	    return $this->percent_change;
	}
}