<?php

class DomainAuthorityComponent extends SimpleComponent
{
	protected $domain_authority, $domain_authority_competitors;
	
	function __construct( $domain_authority=0, $domain_authority_competitors=array() )
	{
		$this->domain_authority = $domain_authority;
		$this->domain_authority_competitors = $domain_authority_competitors;
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
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
		<div id="dv-domain-authority-component">
			<div id="dv-domain-authority">
				<?php echo $this->domain_authority; ?><br />
				Domain Authority
			</div>
			<div id="dv-domain-authority-competitors">
				<table>
					<thead>
			        <tr>
			        	<th>Competitor</th>
			        	<th>Domain Authority</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php foreach ( $this->domain_authority_competitors as $domain_authority_competitor ) { ?>
			        <tr>
			            <td><?php echo $domain_authority_competitor->get_url(); ?></td>
			            <td><?php echo $domain_authority_competitor->get_domain_authority(); ?></td>
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

	public function get_domain_authority()
	{
	    return $this->domain_authority;
	}

	public function get_domain_authority_competitors()
	{
	    return $this->domain_authority_competitors;
	}
}