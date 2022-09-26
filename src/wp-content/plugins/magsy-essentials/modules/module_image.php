<?php

class Magsy_Image_Module extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magsy_module_image',
			esc_html__( 'Magsy Module: Image', 'magsy' ),
			array( 'description' => esc_html__( 'Displays an image.', 'magsy' ) )
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$image = isset( $instance['image'] ) ? $instance['image'] : '';
		$link = isset( $instance['link'] ) ? $instance['link'] : '';
		$new_tab = ! empty( $instance['new_tab'] ) ? 1 : 0;

		echo $before_widget;
    if ( ! empty( $title ) ) {
      echo $before_title . $title . $after_title;
		}

		$image_id = attachment_url_to_postid( $image );
		$alt = get_post_meta( $image_id, '_wp_attachment_image_alt' );
		$alt = ! empty( $alt ) ? $alt[0] : '';
		$caption = wp_get_attachment_caption( $image_id );
		$image_size = 'full';
		
		ob_start(); ?>

		<div class="module image">
			<?php if ( wp_get_attachment_image_srcset( $image_id, $image_size ) ) : ?>
				<img class="lazyload" data-srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $image_id, $image_size ) ); ?>" data-sizes="auto" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $alt ); ?>">
			<?php else :
				$image = wp_get_attachment_image_src( $image_id, $image_size ); ?>
				<img class="lazyload" data-src="<?php echo esc_url( $image[0] ); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $alt ); ?>">  
			<?php endif;

			if ( $caption != '' ) :
				echo '<div class="caption">' . esc_html( $caption ) . '</div>';
			endif;
			
			if ( ! empty( $link ) ) : ?>
				<a class="u-permalink" href="<?php echo esc_url( $link ); ?>"<?php echo esc_attr( $new_tab ? ' target="_blank"' : '' ); ?>></a>
			<?php endif; ?>
		</div> <?php

		echo ob_get_clean();
		echo $after_widget;
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => '',
			'image' => '',
			'link' => '',
			'new_tab' => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image:', 'magsy' ); ?></label>
			<input class="image-url widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['image'] ); ?>" />
			<input class="upload-button button-secondary" type="button" value="<?php esc_html_e( 'Select Image', 'magsy' ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['link'] ); ?>" />
		</p>
		
		<p>
			<input class="checkbox" <?php checked( $instance['new_tab'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" type="checkbox">
			<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e( 'Open link in a new tab?', 'magsy' ); ?></label>
		</p> <?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		$instance['new_tab'] = ( ! empty( $new_instance['new_tab'] ) ) ? 1 : 0;

		return $instance;
	}

	public function enqueue_scripts() {
    wp_enqueue_media();
    wp_enqueue_script( 'magsy_widget_upload', plugin_dir_url( __DIR__ ) . 'js/upload-media.js', array( 'jquery' ) );
  }

}