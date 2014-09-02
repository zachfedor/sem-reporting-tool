<?php

class Visit extends SimpleComponent
{
	protected $month_start_date, $type, $num_visits, $percent_change;
	
	function __construct( $month_start_date='', $type='', $num_visits=0, $percent_change=0 )
	{
		$this->month_start_date = $month_start_date;
		$this->type = $type;
		$this->num_visits = $num_visits;
		$this->percent_change = $percent_change;
	}

	public function get_month_start_date()
	{
	    return $this->month_start_date;
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