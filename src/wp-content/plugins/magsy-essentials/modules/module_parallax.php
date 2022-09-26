<?php

class Magsy_Parallax_Module extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magsy_module_parallax',
			esc_html__( 'Magsy Module: Parallax', 'magsy' ),
			array( 'description' => esc_html__( 'Displays a parallax background.', 'magsy' ) )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$image = isset( $instance['image'] ) ? $instance['image'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$link = isset( $instance['link'] ) ? $instance['link'] : '';
		$new_tab = ! empty( $instance['new_tab'] ) ? 1 : 0;
		$primary_text = isset( $instance['primary_text'] ) ? $instance['primary_text'] : '';
		$primary_link = isset( $instance['primary_link'] ) ? $instance['primary_link'] : '';
		$primary_new_tab = ! empty( $instance['primary_new_tab'] ) ? 1 : 0;
		$secondary_text = isset( $instance['secondary_text'] ) ? $instance['secondary_text'] : '';
		$secondary_link = isset( $instance['secondary_link'] ) ? $instance['secondary_link'] : '';
		$secondary_new_tab = ! empty( $instance['secondary_new_tab'] ) ? 1 : 0;

		echo $before_widget;
    if ( ! empty( $title ) ) {
      echo '<div class="container">' . $before_title . $title . $after_title . '</div>';
		}

		$image_id = attachment_url_to_postid( $image );
		$alt = get_post_meta( $image_id, '_wp_attachment_image_alt' );
		$alt = ! empty( $alt ) ? $alt[0] : '';
		$image_size = 'full';
		
		ob_start(); ?>

		<div class="module parallax">
			<?php if ( wp_get_attachment_image_srcset( $image_id, $image_size ) ) : ?>
				<img class="jarallax-img lazyload" data-srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $image_id, $image_size ) ); ?>" data-sizes="auto" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $alt ); ?>">
			<?php else :
				$image = wp_get_attachment_image_src( $image_id, $image_size ); ?>
				<img class="jarallax-img lazyload" data-src="<?php echo esc_url( $image[0] ); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $alt ); ?>">  
			<?php endif;
			
			if ( $text != '' ) : ?>
				<div class="container">
					<h4 class="entry-title">
						<?php echo wp_kses( $text, array(
							'br' => array(),
						) ); ?>
					</h4>
					<?php if ( $primary_text != '' ) : ?>
						<a class="button" href="<?php echo esc_url( $primary_link ); ?>"<?php echo esc_attr( $primary_new_tab ? ' target="_blank"' : '' ); ?>><?php echo esc_html( $primary_text ); ?></a>
					<?php endif; ?>
					<?php if ( $secondary_text != '' ) : ?>
						<a class="button transparent" href="<?php echo esc_url( $secondary_link ); ?>"<?php echo esc_attr( $secondary_new_tab ? ' target="_blank"' : '' ); ?>><?php echo esc_html( $secondary_text ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif;

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
			'text' => '',
			'link' => '',
			'new_tab' => 0,
			'primary_text' => '',
			'primary_link' => '',
			'primary_new_tab' => 0,
			'secondary_text' => '',
			'secondary_link' => '',
			'secondary_new_tab' => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['image'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['text'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['link'] ); ?>" />
		</p>
		
		<p>
			<input class="checkbox" <?php checked( $instance['new_tab'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" type="checkbox">
			<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e( 'Open link in a new tab?', 'magsy' ); ?></label>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'primary_text' ) ); ?>"><?php esc_html_e( 'Primary button text:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'primary_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'primary_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['primary_text'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'primary_link' ) ); ?>"><?php esc_html_e( 'Primary button link:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'primary_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'primary_link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['primary_link'] ); ?>" />
		</p>
		
		<p>
			<input class="checkbox" <?php checked( $instance['primary_new_tab'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'primary_new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'primary_new_tab' ) ); ?>" type="checkbox">
			<label for="<?php echo esc_attr( $this->get_field_id( 'primary_new_tab' ) ); ?>"><?php esc_html_e( 'Open link in a new tab?', 'magsy' ); ?></label>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'secondary_text' ) ); ?>"><?php esc_html_e( 'Secondary button text:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'secondary_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'secondary_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['secondary_text'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'secondary_link' ) ); ?>"><?php esc_html_e( 'Secondary button link:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'secondary_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'secondary_link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['secondary_link'] ); ?>" />
		</p>
		
		<p>
			<input class="checkbox" <?php checked( $instance['secondary_new_tab'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'secondary_new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'secondary_new_tab' ) ); ?>" type="checkbox">
			<label for="<?php echo esc_attr( $this->get_field_id( 'secondary_new_tab' ) ); ?>"><?php esc_html_e( 'Open link in a new tab?', 'magsy' ); ?></label>
		</p> <?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image'] ) : '';
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		$instance['new_tab'] = ( ! empty( $new_instance['new_tab'] ) ) ? 1 : 0;
		$instance['primary_text'] = ( ! empty( $new_instance['primary_text'] ) ) ? strip_tags( $new_instance['primary_text'] ) : '';
		$instance['primary_link'] = ( ! empty( $new_instance['primary_link'] ) ) ? strip_tags( $new_instance['primary_link'] ) : '';
		$instance['primary_new_tab'] = ( ! empty( $new_instance['primary_new_tab'] ) ) ? 1 : 0;
		$instance['secondary_text'] = ( ! empty( $new_instance['secondary_text'] ) ) ? strip_tags( $new_instance['secondary_text'] ) : '';
		$instance['secondary_link'] = ( ! empty( $new_instance['secondary_link'] ) ) ? strip_tags( $new_instance['secondary_link'] ) : '';
		$instance['secondary_new_tab'] = ( ! empty( $new_instance['secondary_new_tab'] ) ) ? 1 : 0;

		return $instance;
	}

}