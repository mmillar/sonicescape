<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_content(); ?>" data-autoplay="0" class="grid-3">

		<?php the_post_thumbnail(array(300,300)); ?>
		<span class="grid-title">
			<a href="" rel="bookmark"><?php the_title(); ?></a>
		</span>

	</article><!-- #post -->
