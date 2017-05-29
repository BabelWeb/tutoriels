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

/* 1ere version */
		<div class="entry-acf">
			<?php if( get_field('prix') ): ?>
				<div class="acf-prix"><label>Prix : </label><?php format_prix(get_field("prix"), " "); ?> € </div><!-- acf-prix -->
			<?php endif; ?>
			<?php if( get_field('surface') ): ?>
				<div class="acf-surf"><label>Surface : </label><?php the_field("surface"); ?> m<sup>2</sup> </div><!-- acf-surf -->
			<?php endif; ?>
			<?php if( get_field('lieu') ): ?>
				<div class="acf-lieu"><label>Lieu : </label><?php the_field("lieu"); ?> </div><!-- acf-lieu -->
			<?php endif; ?>
		</div><!-- .entry-meta -->
