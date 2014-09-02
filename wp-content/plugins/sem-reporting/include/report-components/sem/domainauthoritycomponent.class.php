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

	public function get_domain_authority()
	{
	    return $this->domain_authority;
	}

	public function get_domain_authority_competitors()
	{
	    return $this->domain_authority_competitors;
	}
}