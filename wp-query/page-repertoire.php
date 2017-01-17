<?php
/**
 * Template Name: Template Répertoire
 *
 * Description: Une page qui affiche tous les biens immobiliers par lieu classé par ordre alphabétique.
 *
 * @package WordPress
 * @subpackage Babel_Web_Tutoriels
 * @since Babel Web Tutoriels 1.0
 */

?>
<?php get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

		<header class="page-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php the_content(); ?>
		</header><!-- .page-header -->

		<div id="immo-directory" class="immo-directory">
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
		</div> <!-- .immo-grid -->
		
		<?php endwhile;	?>
	<?php endif; ?>
	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
