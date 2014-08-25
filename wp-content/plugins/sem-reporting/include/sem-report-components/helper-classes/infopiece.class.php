<?php

class InfoPiece extends SimpleHelper
{
	protected $name, $type, $value;
	
	function __construct( $name='', $type='', $value=0 )
	{
		$this->$name = $name;
		$this->type = $type;
		$this->value = $value;
	}
}