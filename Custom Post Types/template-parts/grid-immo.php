<?php
/**
 * The template part for displaying immo content in grid form
 *
 * @package WordPress
 * @subpackage Babel_Web_Tutoriels
 * @since Babel Web Tutoriels 1.0
 */
?>

<figure id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php echo esc_url( get_permalink() ) ?>">
	<?php the_post_thumbnail("medium"); ?>
	<figcaption>
		<h2><?php 
			$term_list = wp_get_post_terms($post->ID, 'type-immo', array("fields" => "names"));
			echo $term_list[0];
		?></h2>
		<p class='description'><?php the_title(); ?></p>
	</figcaption>
</figure>