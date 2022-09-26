<?php

class Magsy_Post_List_Module extends Magsy_Post_Base_Module {

  public function __construct() {
		parent::__construct(
			'magsy_module_post_list',
			esc_html__( 'Magsy Module: Post List', 'magsy' ),
			array( 'description' => esc_html__( 'A list of posts.', 'magsy' ) )
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

    <div class="module list u-module-margin">
      <div class="row">
        <?php while ( $this->data->have_posts() ) : $this->data->the_post(); ?>
          <div class="col-lg-6">
            <article <?php post_class( 'post post-list' ); ?>>
              <?php magsy_entry_media( array( 'layout' => 'rect_300' ) ); ?>
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