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
		$arr = json_decode( $json, true );
		
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
                <div class="rc-col rc-col-one rc-col-border">
                    <table class="rc-table">
                        <tr>
                            <th class="rc-table-head">Total Visits</th>
                            <td class="rc-table-dark"><?php echo $this->total_visits; ?></td>
                        </tr>
                    </table>

                    <div class="rc-piegraph">

                        <div id="canvas-holder">
                            <canvas id="chart-area" width="250" height="250" />
                        </div>

                        <?php
                        $pie_slices = count($this->visits);
                        $pie_total = 0;
                        $visit_breakdown = array();
                        foreach ( $this->visits as $visit_type ) {
                            array_push($visit_breakdown, $visit_type->get_num_visits());
                            $pie_total += $visit_type->get_num_visits();
                        }

                        ?>

                        <script>

                            var pieData = [
                                <?php
                                    $pie_colors = array('#C3D500','#00a0d5','#ffb553','#d50000','#949fb2','#ffb800','#634aa6');
                                    $numItems = count($this->visits);
                                    $i = 0;
                                    foreach ( $this->visits as $slice ) {
                                        echo "{";
                                        echo "value: " . $slice->get_num_visits() . ",";
                                        echo 'color: "' . $pie_colors[$i] . '",';
                                        echo 'highlight: "' . $pie_colors[$i] . '",';
                                        echo 'label: "' . $slice->get_type() . '"';

                                        if(++$i === $numItems) {
                                            echo "}";
                                        } else {
                                            echo "},";
                                        }
                                    }
                                ?>
                            ];

                            window.onload = function(){
                                var ctx = document.getElementById("chart-area").getContext("2d");
                                window.myPie = new Chart(ctx).Pie(pieData);
                            };
                        </script>

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
                        <?php
                        $i = 0;

                        foreach ( $this->visits as $visit_type ) { ?>
                        <tr>
                            <td class="rc-table-dark" style="background-color: <?php echo $pie_colors[$i] ?>;"><?php echo ucfirst( $visit_type->get_type() ); ?></td>
                            <td class="rc-table-light"><?php echo $visit_type->get_num_visits(); ?></td>
                        </tr>
                        <?php
                        $i++;
                        } ?>
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