<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					$post_meta = get_post_meta( get_the_ID() );
					
					if ( isset( $post_meta['wpcf-facebook'] ) )
					{
						$facebook_component = FacebookComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-facebook'][0] ) );
						echo $facebook_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-google-analytics'] ) )
					{
						$google_analytics_component = GoogleAnalyticsComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-google-analytics'][0] ) );
						echo $google_analytics_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-linkedin'] ) )
					{
						$linked_in_component = LinkedInComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-linkedin'][0] ) );
						echo $linked_in_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-pinterest'] ) )
					{
						$pinterest_component = PinterestComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-pinterest'][0] ) );
						echo $pinterest_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-twitter'] ) )
					{
						$twitter_component = TwitterComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-twitter'][0] ) );
						echo $twitter_component->to_html();
						echo '<br /><br />';
					}
					
					if ( isset( $post_meta['wpcf-youtube'] ) )
					{
						$youtube_component = YouTubeComponent::get_from_serialized_array( unserialize( $post_meta['wpcf-youtube'][0] ) );
						echo $youtube_component->to_html();
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
