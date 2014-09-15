<?php
/*
Template Name: SE Category Grid Page
*/

get_header();

$layout = get_post_meta(get_the_ID(), "grid-layout", true);
$submenu = get_post_meta(get_the_ID(), "sub-menu", true);
?>

	<?php if($submenu) { ?>

	<div id="page-navigation" class="sub-navigation">
		<?php wp_nav_menu( array( 'theme_location' => $submenu, 'menu_class' => 'nav-menu' ) ); ?>
	</div>

	<?php } 

	query_posts( array ( 'category_name' => get_post_meta(get_the_ID(), "category", true), 'posts_per_page' => 20 ) );
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
