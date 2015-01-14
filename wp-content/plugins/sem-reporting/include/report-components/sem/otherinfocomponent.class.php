<?php

class OtherInfoComponent extends SimpleComponent
{
	protected $sessions, $pages_per_session, $average_session_duration, $bounce_rate;
	
	function __construct( $sessions=0, $pages_per_session=0, $average_session_duration=0, $bounce_rate=0 )
	{
		$this->sessions = $sessions;
		$this->pages_per_session = $pages_per_session;
		$this->average_session_duration = $average_session_duration;
		$this->bounce_rate = $bounce_rate;
	}
	
	public static function get_by_client( $client )
	{
		return Google::get_sem_other_info_component( $client );
	}
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json, true );
		
		return self::get_from_array( $arr );
	}
	
	public static function get_from_array( $arr )
	{
		return new self( $arr['sessions'], $arr['pages_per_session'], $arr['average_session_duration'], $arr['bounce_rate'] );
	}

    function get_historical_data( $post_title, $num_months=2 )
    {
        $this->previous_month_components = $this->get_previous_months( $post_title, $num_months, 'sem-report', 'wpcf-other-information' );
    }
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-other-info-component" class="report-component">
			<h3 class="rc-title rc-full">Other Information</h3>

            <div class="rc-content">
                <div class="rc-clear">
                    <div class="rc-col rc-col-one rc-col-border">
                        <h5 class="rc-heading">Sessions / Visits</h5>
                        <p class="rc-data"><?php echo $this->sessions; ?></p>
                    </div>
                    <div class="rc-col rc-col-two">
                        <table class="rc-table">
                            <tr>
                                <th class="rc-table-head">3 Months Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 1 )->get_sessions(); ?></td>
                            </tr>
                            <tr>
                                <th class="rc-table-head">One Year Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 2 )->get_sessions(); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr/>

                <div class="rc-clear">
                    <div class="rc-col rc-col-one rc-col-border">
                        <h5 class="rc-heading">Avg. Session Duration:</h5>
                        <p class="rc-data"><?php echo $this->average_session_duration; ?></p>
                    </div>
                    <div class="rc-col rc-col-two">
                        <table class="rc-table">
                            <tr>
                                <th class="rc-table-head">3 Months Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 1 )->get_average_session_duration(); ?></td>
                            </tr>
                            <tr>
                                <th class="rc-table-head">One Year Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 2 )->get_average_session_duration(); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr/>

                <div class="rc-clear">
                    <div class="rc-col rc-col-one rc-col-border">
                        <h5 class="rc-heading">Pages / Session:</h5>
                        <p class="rc-data"><?php echo $this->pages_per_session; ?></p>
                    </div>
                    <div class="rc-col rc-col-two">
                        <table class="rc-table">
                            <tr>
                                <th class="rc-table-head">3 Months Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 1 )->get_pages_per_session(); ?></td>
                            </tr>
                            <tr>
                                <th class="rc-table-head">One Year Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 2 )->get_pages_per_session(); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr/>

                <div class="rc-clear">
                    <div class="rc-col rc-col-one rc-col-border">
                        <h5 class="rc-heading">Bounce Rate:</h5>
                        <p class="rc-data"><?php echo $this->bounce_rate; ?>%</p>
                    </div>
                    <div class="rc-col rc-col-two">
                        <table class="rc-table">
                            <tr>
                                <th class="rc-table-head">3 Months Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 1 )->get_bounce_rate(); ?></td>
                            </tr>
                            <tr>
                                <th class="rc-table-head">One Year Ago</th>
                                <td class="rc-table-light"><?php echo $this->get_previous_month_component( 2 )->get_bounce_rate(); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
             </div>
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
	}

	public function get_sessions()
	{
	    return $this->sessions;
	}

	public function get_pages_per_session()
	{
	    return $this->pages_per_session;
	}

	public function get_average_session_duration()
	{
	    return $this->average_session_duration;
	}

	public function get_bounce_rate()
	{
	    return $this->bounce_rate;
	}
}