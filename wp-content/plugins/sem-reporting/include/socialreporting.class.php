<?php
class SocialReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'generate_report' ) );
	}
	
	function generate_report()
	{
		$test_component = Moz::get_competitor_link_metrics_component( 'tower' );
		
		echo '<pre>';
		//echo($test_component->to_serialize());
		$test = CompetitorLinkMetricsComponent::get_from_serialized_array( 'a:2:{s:12:"link_metrics";a:2:{s:4:"link";s:22:"www.towermarketing.net";s:7:"metrics";a:7:{i:0;a:2:{s:4:"name";s:16:"Domain Authority";s:5:"value";d:35;}i:1;a:2:{s:4:"name";s:23:"External Followed Links";s:5:"value";i:4411;}i:2;a:2:{s:4:"name";s:29:"Followed Linking Root Domains";s:5:"value";i:4515;}i:3;a:2:{s:4:"name";s:14:"Domain Mozrank";s:5:"value";d:4.1500000000000003552713678800500929355621337890625;}i:4;a:2:{s:4:"name";s:15:"Domain Moztrust";s:5:"value";d:4.53000000000000024868995751603506505489349365234375;}i:5;a:2:{s:4:"name";s:20:"Total External Links";s:5:"value";i:4414;}i:6;a:2:{s:4:"name";s:26:"Total Linking Root Domains";s:5:"value";i:20;}}}s:23:"competitor_link_metrics";a:3:{i:0;a:2:{s:4:"link";s:18:"www.ezsolution.com";s:7:"metrics";a:7:{i:0;a:2:{s:4:"name";s:16:"Domain Authority";s:5:"value";d:61;}i:1;a:2:{s:4:"name";s:23:"External Followed Links";s:5:"value";i:3591;}i:2;a:2:{s:4:"name";s:29:"Followed Linking Root Domains";s:5:"value";i:4287;}i:3;a:2:{s:4:"name";s:14:"Domain Mozrank";s:5:"value";d:5.80999999999999960920149533194489777088165283203125;}i:4;a:2:{s:4:"name";s:15:"Domain Moztrust";s:5:"value";d:5.6500000000000003552713678800500929355621337890625;}i:5;a:2:{s:4:"name";s:20:"Total External Links";s:5:"value";i:8026;}i:6;a:2:{s:4:"name";s:26:"Total Linking Root Domains";s:5:"value";i:1428;}}}i:1;a:2:{s:4:"link";s:22:"www.synapseresults.com";s:7:"metrics";a:7:{i:0;a:2:{s:4:"name";s:16:"Domain Authority";s:5:"value";d:34;}i:1;a:2:{s:4:"name";s:23:"External Followed Links";s:5:"value";i:111;}i:2;a:2:{s:4:"name";s:29:"Followed Linking Root Domains";s:5:"value";i:1329;}i:3;a:2:{s:4:"name";s:14:"Domain Mozrank";s:5:"value";d:4.9900000000000002131628207280300557613372802734375;}i:4;a:2:{s:4:"name";s:15:"Domain Moztrust";s:5:"value";d:4.980000000000000426325641456060111522674560546875;}i:5;a:2:{s:4:"name";s:20:"Total External Links";s:5:"value";i:126;}i:6;a:2:{s:4:"name";s:26:"Total Linking Root Domains";s:5:"value";i:23;}}}i:2;a:2:{s:4:"link";s:16:"www.webtekcc.com";s:7:"metrics";a:7:{i:0;a:2:{s:4:"name";s:16:"Domain Authority";s:5:"value";d:50;}i:1;a:2:{s:4:"name";s:23:"External Followed Links";s:5:"value";i:9251;}i:2;a:2:{s:4:"name";s:29:"Followed Linking Root Domains";s:5:"value";i:10927;}i:3;a:2:{s:4:"name";s:14:"Domain Mozrank";s:5:"value";d:5.44000000000000039079850466805510222911834716796875;}i:4;a:2:{s:4:"name";s:15:"Domain Moztrust";s:5:"value";d:5.30999999999999960920149533194489777088165283203125;}i:5;a:2:{s:4:"name";s:20:"Total External Links";s:5:"value";i:9375;}i:6;a:2:{s:4:"name";s:26:"Total Linking Root Domains";s:5:"value";i:372;}}}}}' );
		print_r( $test->to_array() );
		echo '</pre>';
	}
	
	function elog( $stuff )
	{
	  ob_start();
	  if ( is_array( $stuff ) )
	  {
	  	print_r( $stuff );
	  }
	  else
	  {
	  	echo $stuff;
	  }
	  $contents = ob_get_contents();
	  ob_end_clean();
	 
	  error_log( $contents );
	}
}