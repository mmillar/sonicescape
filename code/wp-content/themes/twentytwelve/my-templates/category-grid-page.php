<?php
/*
Template Name: SE Category Grid Page
*/

get_header();

query_posts( array ( 'category_name' => get_post_meta(get_the_ID(), "category", true), 'posts_per_page' => 20 ) );
$layout = get_post_meta(get_the_ID(), "grid-layout", true);
?>


	<div id="primary" class="site-content" style="width: 100%; max-width: 960px">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', $layout ); ?>
			<?php comments_template( '', true ); ?>
			
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>
