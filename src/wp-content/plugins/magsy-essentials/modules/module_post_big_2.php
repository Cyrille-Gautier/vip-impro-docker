<?php

class Magsy_Post_Big_2_Module extends Magsy_Post_Base_Module {

  public function __construct() {
		parent::__construct(
			'magsy_module_post_big_2',
			esc_html__( 'Magsy Module: Big 2 Posts', 'magsy' ),
			array( 'description' => esc_html__( 'Two big posts.', 'magsy' ) )
		);
  }
  
  public function widget( $args, $instance ) {
    extract( $args );
    parent::widget( $args, $instance );
    $title = isset( $instance['title'] ) ? $instance['title'] : '';

    echo $before_widget;
    if ( ! empty( $title ) ) {
      echo $before_title . $title . $after_title;
    }

    ob_start(); ?>

    <div class="module big u-module-margin">
      <div class="row">
        <?php while ( $this->data->have_posts() ) : $this->data->the_post(); ?>
          <div class="col-md-6">
            <article <?php post_class( 'post post-large' ); ?>>
              <?php magsy_entry_media( array( 'layout' => 'full_800' ) ); ?>
              <div class="entry-wrapper">
                <?php magsy_entry_header( array( 'category' => $this->enable_category ) ); ?>
                <?php if ( $this->excerpt_length > 0 ) : ?>
                  <div class="entry-excerpt u-text-format">
                    <?php magsy_excerpt( $this->excerpt_length ); ?>
                  </div>
                <?php endif; ?>
                <?php get_template_part( 'inc/partials/entry-footer' ); ?>
              </div>
            </article>
          </div>
        <?php endwhile; ?>
      </div>
    </div> <?php

    wp_reset_postdata();
    echo ob_get_clean();
    echo $after_widget;
  }

}