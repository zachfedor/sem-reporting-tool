<?php

class SimpleComponent
{
	public function to_array()
	{
		$arr = array();

		$obj_vars = get_object_vars( $this );

		foreach ( $obj_vars as $key => $val )
		{
			if ( is_array( $val ) )
			{
				$objs = array();

				foreach ( $val as $sub_val )
				{
					$objs[] = $sub_val->to_array();
				}

				$arr[$key] = $objs;
			}
			else
			{
				$arr[$key] = $val;
			}
		}

		return $arr;
	}

	public function to_serialize()
	{
		return serialize( $this->to_array() );
	}
}