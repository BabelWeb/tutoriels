<?php
/**
 * Afficher la description du custom post type
 * @since babel web tutos 1.0
 */
function the_cpt_description ($before = "", $after = "") {
	global $post;
	$post_type = get_post_type_object( get_post_type($post) );
	echo $before.$post_type->description.$after;
}

/**
 * Ajouter les CPT biens immobiliers à la home page.
 * @since babel web tutos 1.0
 */
add_filter( 'pre_get_posts', 'bwt_get_posts' );
function bwt_get_posts( $query ) {
	if ( is_home() ) 
		set_query_var('post_type', array( 'post', 'immo') );
}

/**
 * Displays the optional excerpt.
 * Wraps the excerpt in a div element.
 * Create your own twentysixteen_excerpt() function to override in a child theme.
 * @since Twenty Sixteen 1.0
 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
 */
function twentysixteen_excerpt( $class = 'entry-summary' ) {
	$class = esc_attr( $class );

	if ( (has_excerpt() && !is_single()) || is_search() ) : ?>
		<div class="<?php echo $class; ?>">
			<?php the_excerpt(); ?>
		</div><!-- .<?php echo $class; ?> -->
	<?php endif;
}





/**
 * Enqueue scripts and styles.
 * @since babel web tutos 1.0
 */
function babelweb_scripts() {
	$args = array(
		'nonce' => wp_create_nonce( 'bwt-ajax-nonce' ),
		'url'   => admin_url( 'admin-ajax.php' ),
	);
	wp_enqueue_script( 'grid', get_stylesheet_directory_uri() . '/js/grid.js', array( 'jquery' ), '20160426', false );
	wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . '/js/modernizr.js', array( 'jquery' ), '20160121', false );
	wp_enqueue_script( 'slider', get_stylesheet_directory_uri() . '/js/slider.js', array( 'jquery' ), '20160121', false );
	wp_localize_script( 'slider', 'ajaxdata', $args );
	// wp_enqueue_style( 'cpt', get_stylesheet_directory_uri() . "/cpt.css" );
	// wp_enqueue_style( 'nav-ajax', get_stylesheet_directory_uri() . "/nav-ajax.css" );
}
add_action( 'wp_enqueue_scripts', 'babelweb_scripts' );

function babel_adjacent_content ($pid) {
	global $post;
	$args = array (
		'p'			=> $pid,
	);
	$post = get_posts($args)[0];
	// https://codex.wordpress.org/Template_Tags/get_posts
	// The variable has to be the global (out of the loop) $post
	setup_postdata( $post ); 
	the_content();
	wp_reset_postdata();
}

add_action( 'wp_ajax_babel_nav', 'babel_nav' );
add_action( 'wp_ajax_nopriv_babel_nav', 'babel_nav' );

function babel_nav() {
	check_ajax_referer( 'bwt-ajax-nonce', 'nonce' );
	global $post;
	extract($_POST);
	/*
	 * $action = "babel_nav
	 * $pid = PID de l'article adjacent (précédent ou suivant)
	 * dir = "prev" | "next"
	 */
	$args = array (
		"posts_per_page"	=> 1,
		"order"				=> "ASC"
	);


	// Recherche de l'article adjacent
	$post = get_post($pid);
	setup_postdata( $post ); 

	$url = get_permalink();
	$title = get_the_title();
	
	// Recherche de l'article adjacent à cet article afin qu'il prenne sa place
	if ($dir === "next") {
		if (! $post = get_adjacent_post(false,'',false)) {
			$post = get_posts($args)[0];
		}
	} else {
		if (! $post = get_adjacent_post(false,'',true)) {
			$args["order"] = "DESC";
			$post = get_posts($args)[0];
		}
	}
	// Reset de $post 
	wp_reset_postdata();
	
	// Recherche de l'article de substitution
	$args = array (
		'p'	=> $post->ID,
	);
	$post = get_posts($args)[0];
	setup_postdata( $post ); 
	$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
	$html = get_the_content();

	$output = array (
		'pid'	=> 	$post->ID,
		'html'	=> 	$html,
		'bgimg'	=> 	$image_url[0],
		'title'	=>	$title,
		'url'	=> 	$url,
	);
	// Reset de $post 
	wp_reset_postdata();
	
	// Valeur de retour de mon appel Ajax
	// echo json_encode($output);
	wp_send_json_success( $output );
	// Je meurs, c'est plus sûr ;-)
	wp_die();
}


/*
Ne fonctionne pas car l'insert ou l'update sur les taxonomies arrive après l'insert ou l'update du post

add_filter( 'wp_insert_post_data', 'check_immo_type_unique' );
function check_immo_type_unique( $data ) {
	global $post;
	$term_list = wp_get_post_terms($post->ID, 'type-immo', array("fields" => "names"));
	set_transient( 'check_immo_' . $GLOBALS['current_user']->ID, serialize($term_list) );
	if ( ( ! defined( 'DOING_AUTOSAVE' ) || ! DOING_AUTOSAVE )
		&& 'publish' == $data['post_status'] 
		&& is_a( $post, 'WP_Post' )
		&& 'immo' == $data['post_type'] 
		&& count($term_list) != 1
	){
		$data['post_status'] = 'pending';
		set_transient( 'force_pending_' . $GLOBALS['current_user']->ID, '1' );
	}
	return $data;
}

add_action( 'admin_notices', 'notice_immo_type_unique' );
function notice_immo_type_unique () {
	$class = 'notice notice-error is-dismissible ';
	$message = __( 'Oups ! Vous ne devez saisir qu\'un seul type de bien immobilier.', 'bwt' );
	if ( get_transient( 'force_pending_' . $GLOBALS['current_user']->ID ) )	{
		delete_transient( 'force_pending_' . $GLOBALS['current_user']->ID );
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
	}
}
*/


?>