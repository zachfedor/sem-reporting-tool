<?php

class DomainAuthorityComponent extends SimpleComponent
{
	protected $domain_authority, $domain_authority_competitors;
	
	function __construct( $domain_authority=0, $domain_authority_competitors=array() )
	{
		$this->domain_authority = $domain_authority;
		$this->domain_authority_competitors = $domain_authority_competitors;
	}
}