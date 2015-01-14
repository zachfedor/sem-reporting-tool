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

	public function to_json()
	{
		return json_encode( $this->to_array() );
	}

	public function to_html()
	{
		ob_start();

		include_once( 'social/views/' . strtolower( get_class( $this ) )  . '.view.php' );

		$html = ob_get_clean();

		return $html;
	}

	public function get_previous_months( $post_title, $num_months, $post_type, $post_meta_slug )
	{
		$previous_month_components = array();

		for ( $i = 0; $i < $num_months; $i++ )
		{
			$pieces = explode( ' ', $post_title );
			$year = array_pop( $pieces );
			$month = array_pop( $pieces );
			$post_date = $month . ' ' . $year;

			$post_title_no_date = implode( ' ', $pieces );

			$post_title = $post_title_no_date . ' ' . date( 'F Y', strtotime( $post_date . ' - 1 month' ) );
			$previous_post = get_page_by_title( $post_title, 'ARRAY_A', $post_type );

			$previous_post_meta = get_post_meta( $previous_post['ID'] );

			$previous_month_components[] = call_user_func( get_class( $this ) . '::get_from_json', $previous_post_meta[$post_meta_slug][0] );
		}

		return $previous_month_components;
	}

	public function get_previous_month_component( $num_months_back=1 )
	{
		return $this->previous_month_components[ --$num_months_back ];
	}
}