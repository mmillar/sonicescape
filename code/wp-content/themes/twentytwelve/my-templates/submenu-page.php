<?php
/*
Template Name: SE Page with Sub-menu
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<div id="page-navigation" class="sub-navigation">
		<?php wp_nav_menu( array( 'theme_location' => get_post_meta(get_the_ID(), "sub-menu", true), 'menu_class' => 'nav-menu' ) ); ?>
	</div>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php get_template_part( 'content', 'page' ); ?>
			<?php comments_template( '', true ); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>