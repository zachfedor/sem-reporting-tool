<?php

class DomainAuthorityComponent extends SimpleComponent
{
	protected $domain_authority, $domain_authority_competitors;
	
	function __construct( $domain_authority=0, $domain_authority_competitors=array() )
	{
		$this->domain_authority = $domain_authority;
		$this->domain_authority_competitors = $domain_authority_competitors;
	}
	
	public static function get_by_client( $client )
	{
		return Moz::get_domain_authority_component( $client );
	}
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json, true );
		
		return self::get_from_array( $arr );
	}
	
	public static function get_from_array( $arr )
	{
		$domain_authority_competitors = array();
		foreach( $arr['domain_authority_competitors'] as $domain_authority_competitor )
		{
			$domain_authority_competitors[] = new DomainAuthorityCompetitor( $domain_authority_competitor['url'], $domain_authority_competitor['domain_authority'], $domain_authority_competitor['change'] );
		}
		
		return new self( $arr['domain_authority'], $domain_authority_competitors );
	}
	
	public function to_html()
	{
		ob_start();
		?>
		<div id="dv-domain-authority-component" class="report-component">
			<h3 class="rc-title rc-full">Domain Authority</h3>

            <div class="rc-content">
                <div id="dv-domain-authority" class="rc-col rc-col-one">
                    <h5 class="rc-heading">Your Domain Authority</h5>
                    <p class="rc-data rc-data-big rc-data-accent"><?php echo $this->domain_authority; ?></p>

                    <table id="dv-domain-authority-competitors" class="rc-table">
                        <thead>
                            <tr>
                                <th class="rc-table-head" colspan="2">Competitor Domain Authority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $this->domain_authority_competitors as $domain_authority_competitor ) { ?>
                            <tr>
                                <td class="rc-table-dark"><?php echo $domain_authority_competitor->get_url(); ?></td>
                                <td class="rc-table-light"><?php echo $domain_authority_competitor->get_domain_authority(); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="rc-col rc-col-two">
                    <h4 class="rc-subtitle">Domain Authority History</h4>
                    <h5 class="rc-heading">3 Months Ago</h5>
                    <p class="rc-data rc-data-big">xxx</p>
                    <h5 class="rc-heading">One Year Ago</h5>
                    <p class="rc-data rc-data-big">xxx</p>
                </div>
            </div>
		</div>
		<?php
		$html = ob_get_clean();
		
		return $html;
	}

	public function get_domain_authority()
	{
	    return $this->domain_authority;
	}

	public function get_domain_authority_competitors()
	{
	    return $this->domain_authority_competitors;
	}
}