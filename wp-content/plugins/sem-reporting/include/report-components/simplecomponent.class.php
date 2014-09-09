<?php

class SimpleComponent
{
	public function to_array()
	{
		$arr = array();

		//get the properties of the object
		$obj_vars = get_object_vars( $this );

		//iterate over the object's properties
		foreach ( $obj_vars as $key => $val )
		{
			//if it's an array, need to turn each into array first
			if ( is_array( $val ) )
			{
				$objs = array();

				//turn each object into array
				foreach ( $val as $sub_key => $sub_val )
				{
					//check if already an array
					if ( is_array( $sub_val ) )
					{
						$objs = $val;
					}
					else if ( is_object( $sub_val ) )
					{
						$objs[] = $sub_val->to_array();
					}
					else
					{
						$objs[$sub_key] = $sub_val;
					}
				}

				//add array of objects->array to array
				$arr[$key] = $objs;
			}
			else if ( is_object( $val ) )
			{
				//turn to array and add value to array
				$arr[$key] = $val->to_array();
			}
			else
			{
				//add value to array
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