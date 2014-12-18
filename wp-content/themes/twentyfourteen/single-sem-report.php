<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					$post_meta = get_post_meta( get_the_ID() );
					
					if ( isset( $post_meta['wpcf-competitor-link-metrics'] ) )
					{
						$competitor_link_metrics_component = CompetitorLinkMetricsComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-competitor-link-metrics'][0] ) );
						echo $competitor_link_metrics_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-domain-authority'] ) )
					{
						$domain_authority_component = DomainAuthorityComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-domain-authority'][0] ) );
						echo $domain_authority_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-other-information'] ) )
					{
						$other_info_component = OtherInfoComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-other-information'][0] ) );
						echo $other_info_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-visits'] ) )
					{
						$visits_component = VisitsComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-visits'][0] ) );
						echo $visits_component->to_html();
						echo '<br /><br />';
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();