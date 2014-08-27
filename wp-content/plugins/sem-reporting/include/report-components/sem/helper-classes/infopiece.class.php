<?php

class InfoPiece extends SimpleComponent
{
	protected $name, $type, $value;
	
	function __construct( $name='', $type='', $value=0 )
	{
		$this->$name = $name;
		$this->type = $type;
		$this->value = $value;
	}
}