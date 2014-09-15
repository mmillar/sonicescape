<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Sonice_Escape
 * @since Sonice Escape 1.0
 */

get_header(); 

query_posts(array('category_name' => "news", 'posts_per_page' => 10));
?>

		<?php 
    echo do_shortcode("[metaslider id=38]"); 
?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>

			<article class="post-748 post type-post status-publish format-standard hentry category-news"><div class="entry-content"><p><i>Sonic Escape</i> is a flute-violin-cello trio of Juilliard graduates that uses every part of the performer - fingers, mind, voice &amp; story - to reshape the live music experience.  The virtuoso members have traveled the world in roles as diverse as soloing at Carnegie Hall, fiddle-dancing in <i>Riverdance</i>, jamming with Beale Street blues bands and playing rock clubs across NYC.  Whether <i>Sonic Escape</i> is performing one of their ground-breaking original works, a folk arrangement or a classical masterpiece, they share with audiences as though it's the last note they'll ever play for the best friend they'll ever make!<br></p></div></article>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php twentytwelve_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				// Show the default message to everyone else.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
