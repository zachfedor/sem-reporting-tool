<?php

class DomainAuthorityCompetitor extends SimpleHelper
{
	protected $name, $domain_authority, $change;
	
	function __construct( $name='', $domain_authority=0, $change=0 )
	{
		$this->name = $name;
		$this->domain_authority = $domain_authority;
		$this->change = $change;
	}
}