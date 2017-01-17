<h2>WP_Query</h2>
<?php
$dir_args = array(
	'post_status' 		=> 'publish',
	'post_type' 		=> 'immo',
	'posts_per_page' 	=> -1,
	'no_found_rows' 	=> true,
	'meta_key' 			=> 'lieu',
	'orderby' 			=> 'meta_value',
	'order' 			=> 'desc',
);

$dir = new WP_Query( $dir_args );
if ( $dir->have_posts() ) :
?>

<div class="dir-immo">
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>ID</th>
				<th>Adresse</th>
				<th>Surface</th>
			</tr>
		</thead>
	<?php 
		while ( $dir->have_posts() ) : $dir->the_post(); 
			$map = get_field('lieu');
	?>
		<tr>
			<td><?php echo $post->post_title; ?></td>
			<td><?php echo $post->ID; ?></td>
			<td><?php echo $map["address"]; ?></td>
			<td><?php echo esc_html(get_field('surface')). "&nbsp;m²"; ?></td>
		</tr>
	<?php endwhile;	?>
	</table>
</div>
<?php endif; ?>

<h2>query_posts</h2>
<?php
$dir_args = array(
	'post_status' 		=> 'publish',
	'post_type' 		=> 'immo',
	'posts_per_page' 	=> -1,
	'no_found_rows' 	=> true,
	'meta_key' 			=> 'lieu',
	'orderby' 			=> 'meta_value',
	'order' 			=> 'desc',
);

$dir2 = query_posts( $dir_args );
// global $post;
?>
<div class="dir-immo">
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>ID</th>
				<th>Adresse</th>
				<th>Surface</th>
			</tr>
		</thead>
	<?php 
		foreach ( $dir2 as $post) :
			setup_postdata( $post ); 
			$map = get_field('lieu');
	?>
		<tr>
			<td><?php echo get_the_title(); ?></td>
			<td><?php echo $post->ID; ?></td>
			<td><?php echo $map["address"]; ?></td>
			<td><?php echo esc_html(get_field('surface')). "&nbsp;m²"; ?></td>
		</tr>
	<?php 
		endforeach;	
		wp_reset_query();
	?>
	</table>
</div>

<h2>get_posts</h2>
<?php
$dir_args = array(
	'post_status' 		=> 'publish',
	'post_type' 		=> 'immo',
	'posts_per_page' 	=> -1,
	'no_found_rows' 	=> true,
	'meta_key' 			=> 'lieu',
	'orderby' 			=> 'meta_value',
	'order' 			=> 'desc',
);

$dir2 = get_posts( $dir_args );
?>
<div class="dir-immo">
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>ID</th>
				<th>Adresse</th>
				<th>Surface</th>
			</tr>
		</thead>
	<?php 
		foreach ( $dir2 as $post) :
			setup_postdata( $post ); 
			$map = get_field('lieu');
	?>
		<tr>
			<td><?php echo get_the_title(); ?></td>
			<td><?php echo $post->ID; ?></td>
			<td><?php echo $map["address"]; ?></td>
			<td><?php echo esc_html(get_field('surface')). "&nbsp;m²"; ?></td>
		</tr>
	<?php 
		endforeach;	
		wp_reset_postdata();
	?>
	</table>
</div>


<?php
$terms = get_terms( array(
    'taxonomy' 	=> 'type-immo',
	'oderby'	=> 'name',
	'order'		=> 'desc'
));
foreach($terms as $t) {
	$dir_args = array(
		'post_status' 		=> 'publish',
		'post_type' 		=> 'immo',
		'posts_per_page' 	=> -1,
		'no_found_rows' 	=> true,
		'meta_key' 			=> 'lieu',
		'orderby' 			=> 'meta_value',
		'order' 			=> 'desc',
		'type-immo'			=> $t->name,
	);

$dir2 = get_posts( $dir_args );
?>
<h2>get_posts - <?php echo $t->name; ?></h2>
<div class="dir-immo">
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>ID</th>
				<th>Adresse</th>
				<th>Surface</th>
			</tr>
		</thead>
	<?php 
		foreach ( $dir2 as $post) :
			setup_postdata( $post ); 
			$map = get_field('lieu');
	?>
		<tr>
			<td><?php echo get_the_title(); ?></td>
			<td><?php echo $post->ID; ?></td>
			<td><?php echo $map["address"]; ?></td>
			<td><?php echo esc_html(get_field('surface')). "&nbsp;m²"; ?></td>
		</tr>
	<?php 
		endforeach;	
		wp_reset_postdata();
	?>
	</table>
</div>
<?php
}
?>
