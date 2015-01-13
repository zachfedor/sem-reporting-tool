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
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json );
		
		return self::get_from_array( $arr );
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
            <h3 class="rc-title rc-full">Visits</h3>

            <div class="rc-content">
                <div class="rc-col rc-col-one">
                    <table class="rc-table">
                        <tr>
                            <th class="rc-table-head">Total Visits</th>
                            <td class="rc-table-dark"><?php echo $this->total_visits; ?></td>
                        </tr>
                    </table>

                    <div class="rc-piegraph rc-full">
                        <?php
                        $pie_slices = count($this->visits);
                        $pie_total = 0;
                        $visit_breakdown = array();
                        foreach ( $this->visits as $visit_type ) {
                            array_push($visit_breakdown, $visit_type->get_num_visits());
                            $pie_total += $visit_type->get_num_visits();
                        }

                        $pie_slice_origin = 0;

                        for($i = 0; $i < $pie_slices; $i++) {
                            $pie_slice_percent = $visit_breakdown[$i] / $pie_total;
                            $pie_slice_degrees = $pie_slice_percent * 360;
                            ?>
                            <div data-start="<?php echo $pie_slice_origin; ?>" data-value="<?php echo $pie_slice_degrees; ?>" class="<?php
                            if ($pie_slice_degrees >= 180) {
                                echo "rc-pie rc-pie-big";
                            } else {
                                echo "rc-pie";
                            }
                            ?>" style="-moz-transform: rotate(<?php echo $pie_slice_degrees ?>deg);
                                -ms-transform: rotate(<?php echo $pie_slice_degrees ?>deg);
                                -webkit-transform: rotate(<?php echo $pie_slice_degrees ?>deg);
                                -o-transform: rotate(<?php echo $pie_slice_degrees ?>deg);
                                transform:rotate(<?php echo $pie_slice_degrees ?>deg);"></div>
                            <?php
                            $pie_slice_origin += $pie_slice_degrees;
                        }
                        ?>

                    </div>
                </div>
                <div class="rc-col rc-col-two">
                    <table class="rc-table">
                        <thead>
                        <tr>
                            <th class="rc-table-head">Visit Type</th>
                            <th class="rc-table-head">Number of Visits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $this->visits as $visit_type ) { ?>
                        <tr>
                            <td class="rc-table-dark"><?php echo ucfirst( $visit_type->get_type() ); ?></td>
                            <td class="rc-table-light"><?php echo $visit_type->get_num_visits(); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
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