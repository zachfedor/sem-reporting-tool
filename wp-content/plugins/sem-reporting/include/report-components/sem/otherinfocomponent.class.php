<?php

class OtherInfoComponent  extends SimpleComponent
{
	protected $info_pieces;
	
	function __construct( $info_pieces=array() )
	{
		$this->info_pieces = $info_pieces;
	}
}