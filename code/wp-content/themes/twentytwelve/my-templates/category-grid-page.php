<?php
/*
Template Name: SE Category Grid Page
*/

get_header();

query_posts( array ( 'category_name' => get_post_meta(get_the_ID(), "category", true), 'posts_per_page' => 20 ) );
$layout = get_post_meta(get_the_ID(), "grid-layout", true);
$submenu = get_post_meta(get_the_ID(), "sub-menu", true);
?>

	<?php while ( have_posts() ) : the_post(); ?>

	<?php if($submenu) { ?>

	<div id="page-navigation" class="sub-navigation">
		<?php wp_nav_menu( array( 'theme_location' => get_post_meta(get_the_ID(), "sub-menu", true), 'menu_class' => 'nav-menu' ) ); ?>
	</div>

	<?php } ?>

	<div id="primary" class="site-content" style="width: 100%; max-width: 960px">
		<div id="content" role="main">

			<?php get_template_part( 'content', $layout ); ?>
			<?php comments_template( '', true ); ?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
