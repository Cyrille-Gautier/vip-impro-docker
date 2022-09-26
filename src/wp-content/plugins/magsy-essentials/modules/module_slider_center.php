<?php

class Magsy_Slider_Center_Module extends Magsy_Post_Base_Module {

  public function __construct() {
		parent::__construct(
			'magsy_module_slider_center',
			esc_html__( 'Magsy Module: Center Slider', 'magsy' ),
			array( 'description' => esc_html__( 'A centered slider of posts.', 'magsy' ) )
		);
  }
  
  public function widget( $args, $instance ) {
    extract( $args );
    parent::widget( $args, $instance );
    $title = isset( $instance['title'] ) ? $instance['title'] : '';
    $autoplay = ! empty( $instance['autoplay'] ) ? 1 : 0;

    echo $before_widget;
    if ( ! empty( $title ) ) {
      echo $before_title . $title . $after_title;
    }

    ob_start(); ?>

    <div class="module slider center owl<?php echo esc_attr( $autoplay ? ' autoplay' : '' ); ?>">
      <?php while ( $this->data->have_posts() ) : $this->data->the_post();
        $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'magsy_full_1160' ); ?>
        <article <?php post_class( 'post lazyload visible' ); ?> data-bg="<?php echo esc_url( $bg_image[0] ); ?>">
          <div class="entry-wrapper">
            <?php magsy_entry_header( array( 'tag' => 'h2', 'link' => false, 'white' => true, 'category' => $this->enable_category ) ); ?>
            <?php if ( $this->excerpt_length > 0 ) : ?>
              <div class="entry-excerpt u-text-format">
                <?php magsy_excerpt( $this->excerpt_length ); ?>
              </div>
            <?php endif; ?>
            <?php get_template_part( 'inc/partials/entry-footer' ); ?>
          </div>
          <a class="u-permalink" href="<?php echo esc_url( get_permalink() ); ?>"></a>
        </article>
      <?php endwhile; ?>
    </div> <?php
    
    wp_reset_postdata();
    echo ob_get_clean();
    echo $after_widget;
  }

  public function form( $instance ) {
    parent::form( $instance );

		$defaults = array(
			'autoplay' => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<input class="checkbox" <?php checked( $instance['autoplay'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" type="checkbox">
			<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Autoplay slider?', 'magsy' ); ?></label>
		</p> <?php
  }
  
  public function update( $new_instance, $old_instance ) {
    $parent = parent::update( $new_instance, $old_instance );

		$instance = array();
    $instance['autoplay'] = ( ! empty( $new_instance['autoplay'] ) ) ? 1 : 0;

		return array_merge( $parent, $instance );
	}

}