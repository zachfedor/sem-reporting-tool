<?php

class Visit extends SimpleHelper
{
	protected $month_start_date, $type, $num_visits, $percent_change;
	
	function __construct( $month_start_date='', $type='', $num_visits=0, $percent_change=0 )
	{
		$this->month_start_date = $month_start_date;
		$this->type = $type;
		$this->num_visits = $num_visits;
		$this->percent_change = $percent_change;
	}
}