<?php

class Magsy_Category_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'magsy_category_widget',
      esc_html__( 'Magsy Widget: Categories', 'magsy' ),
      array( 'description' => esc_html__( 'Displays custom categories.', 'magsy' ) )
    );
  }

  public function widget( $args, $instance ) {
    extract( $args );
    $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Categories', 'magsy' );

    echo $before_widget;
    if ( ! empty( $title ) ) {
      echo $before_title . $title . $after_title;
    }

    $categories = get_categories();

    ob_start(); ?>

    <ul>

    <?php foreach ( $categories as $category ) :
      $color = get_term_meta( $category->term_id, 'category_color', true ); ?>

      <li class="category-item">
        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'View all posts in %s', 'magsy' ), $category->name ) ); ?>">
          <span class="category-name">
            <i class="dot" style="background-color: <?php echo esc_attr( $color ); ?>;"></i>
            <?php echo esc_html( $category->name ); ?>
          </span>
          <span class="category-count"><?php echo esc_html( $category->count ); ?></span>
        </a>
      </li>

    <?php endforeach; ?>

    </ul> <?php

    echo ob_get_clean();
    echo $after_widget;
  }

  public function form( $instance ) {
    $defaults = array( 'title' => esc_html__( 'Categories', 'magsy' ) );
    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>

    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $instance;
  }

}