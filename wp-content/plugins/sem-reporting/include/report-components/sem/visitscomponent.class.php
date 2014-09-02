<?php

class VisitsComponent extends SimpleComponent
{
	protected $total_visits, $visits;
	
	function __construct( $total_visits=0, $visits=array() )
	{
		$this->total_visits = $total_visits;
		$this->visits = $visits;
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		$visits = array();
		foreach( $arr['visits'] as $visit )
		{
			$visits[] = new Visit( $arr['month_start_date'], $arr['type'], $arr['num_visits'], $arr['percent_change'] );
		}
		
		return new self( $arr['total_visits'], $visits );
	}

	public function get_total_visits()
	{
	    return $this->total_visits;
	}

	public function get_visits()
	{
	    return $this->visits;
	}
}