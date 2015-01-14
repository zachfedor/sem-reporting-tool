<?php

class DomainAuthorityCompetitor extends SimpleComponent
{
	protected $url, $domain_authority, $change;
	
	function __construct( $url='', $domain_authority=0, $change=0 )
	{
		$this->url = $url;
		$this->domain_authority = $domain_authority;
		$this->change = $change;
	}

	public function get_url()
	{
		if ( strpos( $this->url, 'www.') === 0 )
		{
			return substr( $this->url, 4 );
		}
	    return $this->url;
	}

	public function get_domain_authority()
	{
	    return $this->domain_authority;
	}

	public function get_change()
	{
	    return $this->change;
	}
}