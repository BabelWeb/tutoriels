<?php
/*
===> content-single-immo.php
*/
		<div class="entry-acf">
			<?php if( get_field('prix') ): ?>
				<div class="acf-prix"><label>Prix : </label><?php format_prix(get_field("prix"), " "); ?> € <?php tooltip("prix"); ?></div><!-- acf-prix -->
			<?php endif; ?>
			<?php if( get_field('surface') ): ?>
				<div class="acf-surf"><label>Surface : </label><?php the_field("surface"); ?> m<sup>2</sup> <?php tooltip("surface"); ?></div><!-- acf-surf -->
			<?php endif; ?>
			<?php 
				$map = get_field('lieu');
				if( !empty($map) ):
			?>
			<div class="acf-map">
				<div class="marker" data-lat="<?php echo $map['lat']; ?>" data-lng="<?php echo $map['lng']; ?>">
					<div class="marker-info">
						<h4><?php the_title(); ?></h4>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div><!-- .entry-meta -->

/*
===> header.php
*/
	<?php 	if ("immo" == get_post_type() && is_single()) : ?>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<?php endif; ?>

/*
===> functions.php
*/
	if ("immo" == get_post_type() && is_single())
		wp_enqueue_script( 'acf-map', get_stylesheet_directory_uri() . '/js/acf-map.js', array( 'jquery' ), '20160121', false );

/* 
 * Formatte le prix en séparant les milliers
 */
function get_format_prix($prix, $sep = ".") {
	if (strlen($prix) > 3) {
		$limit = ceil(strlen($prix) / 3);
		$prix_format = "";
		$prix = strrev ($prix);
		for ($i=0;$i<$limit;$i++)
			if ($i+1 == $limit)
				$prix_format .= substr($prix, $i*3, 3);
			else
				$prix_format .= substr($prix, $i*3, 3).$sep;
		$prix = strrev($prix_format);
	}
	return $prix;
}

/* 
 * Affiche le prix formatté sur les milliers
 */
function format_prix ($prix, $sep = ".") {
	echo get_format_prix($prix, $sep);
}

/* 
 * Affiche le tooltip avec les instructions du champs
 */
function tooltip ($field_name) {
	$field = get_field_object($field_name);
	echo "<span class='tooltip'><div class='tooltip-description'>".$field["instructions"]."</div></span>";
}

?>