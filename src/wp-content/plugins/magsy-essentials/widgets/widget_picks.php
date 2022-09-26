<?php

class Magsy_Picks_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magsy_picks_widget',
			esc_html__( 'Magsy Widget: Picked Posts', 'magsy' ),
			array( 'description' => esc_html__( 'Hand picked posts.', 'magsy' ) )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Picked Posts', 'magsy' );
		$ids = isset( $instance['ids'] ) ? $instance['ids'] : '';
		$icon_code = isset( $instance['icon_code'] ) ? $instance['icon_code'] : '';
		$icon_bg = isset( $instance['icon_bg'] ) ? $instance['icon_bg'] : '';
		$icon_color = isset( $instance['icon_color'] ) ? $instance['icon_color'] : '';

		echo $before_widget;
		if ( ! empty( $title ) ) {
      echo $before_title . $title . $after_title;
    }

		$args = array(
			'ignore_sticky_posts' => true,
			'orderby' => 'post__in',
			'post_status' => 'publish',
			'post__in' => explode( ',', $ids ),
		);

		$picks = new WP_Query( $args );

		ob_start(); ?>

		<?php if ( $picks->have_posts() ) : ?>
			<div class="picks-wrapper">
				<?php if ( $icon_code != '' ) :
					$icon_style = 'border-top-color: ' . $icon_bg . '; color: ' . $icon_color . ';' ?>
					<div class="icon" data-icon="&#x<?php echo esc_attr( $icon_code ); ?>" style="<?php echo esc_attr( $icon_style ); ?>"></div>
				<?php endif; ?>
				<div class="picked-posts owl">
					<?php while ( $picks->have_posts() ) : $picks->the_post();
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' ); ?>
						<article class="post">
							<div class="entry-thumbnail">
								<img class="lazyload" data-src="<?php echo esc_url( $image[0] ); ?>">
							</div>
							<?php magsy_entry_header( array( 'tag' => 'h6', 'link' => false ) ); ?>
							<a class="u-permalink" href="<?php echo esc_url( get_the_permalink() ); ?>"></a>
						</article>
					<?php endwhile; ?>
				</div>
			</div>
    <?php endif;

		wp_reset_postdata();

		echo ob_get_clean();
		echo $after_widget;
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => esc_html__( 'Picked Posts', 'magsy' ),
			'ids' => '',
			'icon_code' => '',
			'icon_bg' => '',
			'icon_color' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php esc_html_e( 'Post ids (separated by comma):', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['ids'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon_code' ) ); ?>"><?php esc_html_e( 'Icon code:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_code' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_code'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon_bg' ) ); ?>"><?php esc_html_e( 'Icon background:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_bg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_bg' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_bg'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>"><?php esc_html_e( 'Icon color:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_color' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_color'] ); ?>" />
		</p> <?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['ids'] = ( ! empty( $new_instance['ids'] ) ) ? strip_tags( $new_instance['ids'] ) : '';
		$instance['icon_code'] = ( ! empty( $new_instance['icon_code'] ) ) ? strip_tags( $new_instance['icon_code'] ) : '';
		$instance['icon_bg'] = ( ! empty( $new_instance['icon_bg'] ) ) ? strip_tags( $new_instance['icon_bg'] ) : '';
		$instance['icon_color'] = ( ! empty( $new_instance['icon_color'] ) ) ? strip_tags( $new_instance['icon_color'] ) : '';

		return $instance;
	}

}