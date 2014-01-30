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

	<article id="post-<?php the_ID(); ?>" class="grid-4" onclick="window.location = '<?php the_permalink(); ?>';" style="cursor:pointer">
		<?php the_post_thumbnail(array(300,300)); ?>
		<span class="grid-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</span>

	</article><!-- #post -->
