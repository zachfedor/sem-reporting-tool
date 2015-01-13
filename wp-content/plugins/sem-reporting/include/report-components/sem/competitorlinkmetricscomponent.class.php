<?php

class CompetitorLinkMetricsComponent extends SimpleComponent
{
	protected $link_metrics, $competitor_link_metrics;
	
	function __construct( $link_metrics=null, $competitor_link_metrics=array() )
	{
		if ( $link_metrics != null )
		{
			$this->link_metrics = $link_metrics;
		}
		else
		{
			$this->link_metrics = new LinkMetrics();
		}
		$this->competitor_link_metrics = $competitor_link_metrics;
	}
	
	public static function get_by_client( $client )
	{
		return Moz::get_competitor_link_metrics_component( $client );
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		$link_metrics_metrics = array();
		foreach ( $arr['link_metrics']['metrics'] as $metric )
		{
			$link_metrics_metrics[] = new LinkMetric( $metric['name'], $metric['value'] );
		}
		
		$link_metrics = new LinkMetrics( $arr['link_metrics']['link'], $link_metrics_metrics );
		
		$competitor_link_metrics = array();
		foreach ( $arr['competitor_link_metrics'] as $competitor )
		{
			$competitor_metrics = array();
			foreach ( $competitor['metrics'] as $competitor_metric )
			{
				$competitor_metrics[] = new LinkMetric( $competitor_metric['name'], $competitor_metric['value'] );
			}
			
			$competitor_link_metrics[] = new LinkMetrics( $competitor['link'], $competitor_metrics );
		}
		
		return new self( $link_metrics, $competitor_link_metrics );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-competitor-link-metrics-component" class="report-component">
			<h3 class="rc-title rc-full">Competitor Link Metrics</h3>

            <div class="rc-content">
                <div class="rc-full">
                    <table id="tbl-competitor-link-metrics" class="rc-table">
                        <thead>
                            <tr>
                                <th class="rc-table-head">Metric</th>
                                <th class="rc-table-green" title="<?php echo $this->link_metrics->get_link(); ?>"><?php echo $this->link_metrics->get_link(); ?></th>
                                <?php foreach ( $this->competitor_link_metrics as $competitor ) { ?>
                                <th class="rc-table-head" title="<?php echo $competitor->get_link(); ?>"><?php echo $competitor->get_link(); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $this->link_metrics->get_metrics() as $row => $metric ) { ?>
                            <tr>
                                <td class="rc-table-white"><?php echo $metric->get_name(); ?></td>
                                <td class="rc-table-green"><?php echo $metric->get_value(); ?></td>
                                <?php foreach ( $this->competitor_link_metrics as $competitor ) { ?>
                                <td class="rc-table-white"><?php $competitor_metrics = $competitor->get_metrics(); echo $competitor_metrics[$row]->get_value(); ?></td>
                                <?php } ?>
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
	
	public function get_link_metrics()
	{
		return $this->link_metrics;
	}

	public function get_competitor_link_metrics()
	{
	    return $this->competitor_link_metrics;
	}
}