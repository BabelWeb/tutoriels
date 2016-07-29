<?php
/*
Plugin Name: CPT WIDGET
Plugin URI: http://www.babel-web.info/wordpress/plugins/cpt-widget
Description: Display Custom Post Type in a widget
Version: 1.0
Author: Olivier SPADI
Author URI: http://www.babel-web.info/wordpress/plugins/
License: GPL2
Text Domain: bwp-cpt-widget
Domain Path: /lang

Original Author: Olivier SPADI

Copyright 2016  Olivier SPADI (email : olivier.spadi@babel-web.info)
*/

if ( ! class_exists( 'BWP_CPT_Widget' ) ) {

    class BWP_CPT_Widget extends WP_Widget {

        /**
         * Sets up a new Recent Posts widget instance.
         *
         * @since 2.8.0
         * @access public
         */
        public function __construct() {
            $widget_ops = array(
                'classname' => 'bwp-cpt-widget',
                'description' => __( 'Display the custom post types in a widget', 'bwp-cpt-widget' ),
                'customize_selective_refresh' => true,
            );
            parent::__construct( 'bwp-cpt-widget', __( 'Custom Post Type Widget', 'bwp-cpt-widget' ), $widget_ops );
            $this->alt_option_name = 'widget_bwp_cpt_widget';
        }

        /**
         * Outputs the content for the current Recent Posts widget instance.
         *
         * @since 2.8.0
         * @access public
         *
         * @param array $args     Display arguments including 'before_title', 'after_title',
         *                        'before_widget', and 'after_widget'.
         * @param array $instance Settings for the current Recent Posts widget instance.
         */
        public function widget( $args, $instance ) {
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }

			$cpt = ( ! empty( $instance['cpt'] ) ) ? $instance['cpt'] : "";
			if (empty($cpt))
				return;

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Custom Post Type' );

            /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            if ( ! $number )
                $number = 5;
            $show_price = isset( $instance['show_price'] ) ? $instance['show_price'] : false;

            /**
             * Filter the arguments for the Recent Posts widget.
             *
             * @since 3.4.0
             *
             * @see WP_Query::get_posts()
             *
             * @param array $args An array of arguments used to retrieve the recent posts.
             */
            $r = new WP_Query( apply_filters( 'widget_posts_args', array(
                'post_type'           => $cpt,
                'posts_per_page'      => $number,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true
            ) ) );

            if ($r->have_posts()) :
            ?>
            <?php echo $args['before_widget']; ?>
            <?php if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            } ?>
            <ul>
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                <?php if ( $show_price ) : ?>
                    <span class="post-price"><?php echo number_format_i18n(get_field("prix")); ?>&nbsp;€</span>
                <?php endif; ?>
                </li>
            <?php endwhile; ?>
            </ul>
            <?php echo $args['after_widget']; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;
        }

        /**
         * Handles updating the settings for the current Recent Posts widget instance.
         *
         * @since 2.8.0
         * @access public
         *
         * @param array $new_instance New settings for this instance as input by the user via
         *                            WP_Widget::form().
         * @param array $old_instance Old settings for this instance.
         * @return array Updated settings to save.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = sanitize_text_field( $new_instance['title'] );
            $instance['cpt'] = sanitize_text_field( $new_instance['cpt'] );
            $instance['number'] = (int) $new_instance['number'];
            $instance['show_price'] = isset( $new_instance['show_price'] ) ? (bool) $new_instance['show_price'] : false;
            return $instance;
        }

        /**
         * Outputs the settings form for the Recent Posts widget.
         *
         * @since 2.8.0
         * @access public
         *
         * @param array $instance Current settings.
         */
        public function form( $instance ) {
            $title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $show_price = isset( $instance['show_price'] ) ? (bool) $instance['show_price'] : false;
			$cpt 		= isset( $instance['cpt'] ) ? esc_attr( $instance['cpt'] ) : '';
			$args_cpt = array(
			   'public'   => true,
			   '_builtin' => false
			);

			$cpts = get_post_types($args_cpt);
			if (count($cpts)) :
?>
			<p><label for="<?php echo $this->get_field_id( 'cpt' ); ?>"><?php _e( 'CPT:', 'bwp-cpt-widget' ); ?></label>
			<select class="select" id="<?php echo $this->get_field_id( 'cpt' ); ?>" name="<?php echo $this->get_field_name( 'cpt' ); ?>">
				<option value=""><?php _e('Choice an option...', 'bwp-cpt-widget'); ?></option>

<?php
			foreach ($cpts as $posttype) {
				$selected = false;
				if ($posttype == $cpt)
					$selected = true;
?>
				<option value="<?php echo $posttype; ?>" <?php echo $selected ? "selected" : ""; ?>><?php echo $posttype; ?></option>
<?php
			}
?>
			</select>
<?php
			endif;
            
    ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

            <p><input class="checkbox" type="checkbox"<?php checked( $show_price ); ?> id="<?php echo $this->get_field_id( 'show_price' ); ?>" name="<?php echo $this->get_field_name( 'show_price' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_price' ); ?>"><?php _e( 'Display price?', 'bwp-cpt-widget' ); ?></label></p>
    <?php
        }
    }

	// register BWP_CPT_Widget
	function register_bwp_cpt_widget() {
		register_widget( 'BWP_CPT_Widget' );
	}

	// Start the widget
	add_action( 'widgets_init', 'register_bwp_cpt_widget' );

	// init text domain
	add_action('plugins_loaded', 'bwp_cpt_widget_textdomain');
	function bwp_cpt_widget_textdomain() {
		if (function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain('bwp-cpt-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		}
	}
    
}