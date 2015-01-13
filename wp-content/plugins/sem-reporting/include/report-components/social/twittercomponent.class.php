<?php

class TwitterComponent extends SimpleComponent
{
	protected $total_followers, $total_following;
	
	function __construct( $total_followers, $total_following )
	{
		$this->total_followers = $total_followers;
		$this->total_following = $total_following;
	}
	
	public static function get_by_client( $client )
	{
		return Twitter::get_component( $client );
	}
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json, true );
		
		return self::get_from_array( $arr );
	}
	
	public static function get_from_array( $arr )
	{
		return new self( $arr['total_followers'], $arr['total_following'] );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-twitter-component" class="report-component">
			<h3 class="rc-title rc-full">Twitter</h3>
            <div class="rc-content">
                <div class="rc-full">
                    <table class="rc-table">
                        <thead>
                            <tr>
                                <th class="rc-table-head">Date</th>
                                <th class="rc-table-head"># Followers</th>
                                <th class="rc-table-head"># Following</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="rc-table-dark">This Month</td>
                                <td class="rc-table-light"><?php echo $this->total_followers; ?></td>
                                <td class="rc-table-light"><?php echo $this->total_following; ?></td>
                            </tr>
                            <tr>
                                <td class="rc-table-dark">Last Month</td>
                                <td class="rc-table-light"></td>
                                <td class="rc-table-light"></td>
                            </tr>
                            <tr>
                                <td class="rc-table-dark">2 Months Ago</td>
                                <td class="rc-table-light"></td>
                                <td class="rc-table-light"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
	}

	public function get_total_followers()
	{
	    return $this->total_followers;
	}

	public function get_total_following()
	{
	    return $this->total_following;
	}
}