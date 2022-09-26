<?php

class Magsy_Post_Masonry_Module extends Magsy_Post_Base_Module {

  public function __construct() {
		parent::__construct(
			'magsy_module_post_masonry',
			esc_html__( 'Magsy Module: Post Masonry', 'magsy' ),
			array( 'description' => esc_html__( 'A masonry of posts.', 'magsy' ) )
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

    <div class="module masonry u-module-margin">
      <div class="row">
        <div class="grid-sizer col-sm-6 col-md-4 col-lg-3"></div>
        <?php while ( $this->data->have_posts() ) : $this->data->the_post(); ?>
          <div class="grid-item col-sm-6 col-md-4 col-lg-3">
            <article <?php post_class( 'post' ); ?>>
              <?php
                magsy_entry_media( array( 'layout' => 'full_400' ) );
                magsy_entry_header( array( 'category' => $this->enable_category ) );
              ?>
              <?php if ( $this->excerpt_length > 0 ) : ?>
                <div class="entry-excerpt u-text-format">
                  <?php magsy_excerpt( $this->excerpt_length ); ?>
                </div>
              <?php endif; ?>
              <?php get_template_part( 'inc/partials/entry-footer' ); ?>
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