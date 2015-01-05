<?php

class VisitsComponent extends SimpleComponent
{
	protected $total_visits, $visits;
	
	function __construct( $total_visits=0, $visits=array() )
	{
		$this->total_visits = $total_visits;
		$this->visits = $visits;
	}
	
	public static function get_by_client( $client )
	{
		return Google::get_sem_visits_component( $client );
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
			$visits[] = new Visit( $visit['type'], $visit['num_visits'], $visit['percent_change'] );
		}
		
		return new self( $arr['total_visits'], $visits );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-visits-component" class="report-component">
		<h3>Visits</h3>
			<div id="dv-total-visits">Total Visits: <?php echo $this->total_visits; ?></div>
			<div id="dv-visits-breakdown">
				<table>
					<thead>
			        <tr>
			        	<th>Visit Type</th>
			        	<th>Number of Visits</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php foreach ( $this->visits as $visit_type ) { ?>
			        <tr>
			        	<td><?php echo ucfirst( $visit_type->get_type() ); ?></td>
			        	<td><?php echo $visit_type->get_num_visits(); ?></td>
			        </tr>
			        <?php } ?>
			    </tbody>
				</table>
			</div>
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
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