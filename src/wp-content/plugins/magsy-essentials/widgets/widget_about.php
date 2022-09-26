<?php

class Magsy_About_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magsy_about_widget',
			esc_html__( 'Magsy Widget: About', 'magsy' ),
			array( 'description' => esc_html__( 'About the author.', 'magsy' ) )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'About', 'magsy' );
		$name = isset( $instance['name'] ) ? $instance['name'] : '';
		$profile_image = isset( $instance['profile_image'] ) ? $instance['profile_image'] : '';
		$autograph_image = isset( $instance['autograph_image'] ) ? $instance['autograph_image'] : '';
		$description = isset( $instance['description'] ) ? $instance['description'] : '';

		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		ob_start(); ?>

		<img class="profile-image lazyload" data-src="<?php echo esc_url( $profile_image ); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $name ); ?>">

		<?php if ( $description != '' ) : ?>
			<div class="bio">
				<?php echo wp_kses( $description, array(
					'a'      => array( 'href' => array() ),
					'span'   => array( 'style' => array() ),
					'i'      => array( 'class' => array(), 'style' => array() ),
					'em'     => array(),
					'strong' => array(),
					'br'     => array()
				) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $autograph_image != '' ) : ?>
			<div class="profile-autograph">
				<img data-src="<?php echo esc_url( $autograph_image ); ?>" class="profile-autograph lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $name ); ?>">
			</div>
		<?php elseif ( $name != '' && $autograph_image == '' ) : ?>
			<div class="profile-name"><?php echo esc_html( $name ); ?></div>
		<?php endif; ?>

		<?php

		echo ob_get_clean();
		echo $after_widget;
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => esc_html__( 'About', 'magsy' ),
			'name' => '',
			'profile_image' => '',
			'autograph_image' => '',
			'description' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_html_e( 'Name:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'profile_image' ) ); ?>"><?php esc_html_e( 'Profile image:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'profile_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'profile_image' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['profile_image'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'autograph_image' ) ); ?>"><?php esc_html_e( 'Autograph image:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'autograph_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autograph_image' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['autograph_image'] ); ?>" />
		</p>

	  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:', 'magsy' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="4"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['name'] = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : '';
		$instance['profile_image'] = ( ! empty( $new_instance['profile_image'] ) ) ? strip_tags( $new_instance['profile_image'] ) : '';
		$instance['autograph_image'] = ( ! empty( $new_instance['autograph_image'] ) ) ? strip_tags( $new_instance['autograph_image'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? $new_instance['description'] : '';

		return $instance;
	}

}