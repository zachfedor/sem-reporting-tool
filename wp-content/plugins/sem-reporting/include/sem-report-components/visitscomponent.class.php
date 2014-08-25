<?php

class VisitsComponent extends SimpleComponent
{
	protected $total_visits, $visits;
	
	function __construct( $total_visits=0, $visits=array() )
	{
		$this->total_visits = $total_visits;
		$this->visits = $visits;
	}
}