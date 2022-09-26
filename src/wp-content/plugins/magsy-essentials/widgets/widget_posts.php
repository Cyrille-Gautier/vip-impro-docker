<?php

class Magsy_Posts_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'magsy_posts_widget',
      esc_html__( 'Magsy Widget: Posts', 'magsy' ),
      array( 'description' => esc_html__( 'Displays recent/liked/commented posts.', 'magsy' ) )
    );
  }

  public function widget( $args, $instance ) {
    extract( $args );
    $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Posts', 'magsy' );
    $query = isset( $instance['query'] ) ? $instance['query'] : 'recent';
    $count = isset( $instance['count'] ) ? $instance['count'] : 5;
    $reverse = ! empty( $instance['reverse'] ) ? 1 : 0;

    $before_widget = str_replace( 'class="', 'class="widget-posts ', $before_widget );

    echo $before_widget;
    if ( ! empty( $title ) ) {
      echo $before_title . $title . $after_title;
    }

    switch ( $query ) {
      case 'recent' :
        $args = array(
          'ignore_sticky_posts' => true,
          'posts_per_page' => $count,
          'post_status' => 'publish',
        );
        $header = array( 'tag' => 'h6', 'category' => false, 'date' => true );
        break;
      
      case 'liked' :
        $args = array(
          'ignore_sticky_posts' => true,
          'meta_key' => 'magsy_like',
          'meta_query' => array(
            'compare' => '>',
            'key' => 'magsy_like',
            'value' => '0',
          ),
          'orderby' => array(
            'meta_value_num' => 'DESC',
            'post_date' => 'DESC',
          ),
          'posts_per_page' => $count,
          'post_status' => 'publish',
        );
        $header = array( 'tag' => 'h6', 'category' => false, 'like' => true );
        break;
      
      case 'commented' :
        $args = array(
          'ignore_sticky_posts' => true,
          'orderby' => 'comment_count',
          'posts_per_page' => $count,
          'post_status' => 'publish',
        );
        $header = array( 'tag' => 'h6', 'category' => false, 'comment' => true );
        break;
    }

    $recent_posts = new WP_Query( $args );

    ob_start(); ?>

    <div class="posts<?php echo esc_attr( $reverse ? ' reverse' : '' ); ?>">

    <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>

      <div>
        <div class="entry-thumbnail">
          <a class="u-permalink" href="<?php echo esc_url( get_the_permalink() ); ?>"></a>
          <?php if ( has_post_thumbnail() ) :
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' ); ?>
            <img class="lazyload" data-src="<?php echo esc_url( $image[0] ); ?>">
          <?php endif; ?>
        </div>

        <?php magsy_entry_header( $header ); ?>
      </div>

    <?php endwhile; ?>

    </div> <?php

    echo ob_get_clean();
    echo $after_widget;
  }

  public function form( $instance ) {
    $defaults = array(
      'title' => esc_html__( 'Posts', 'magsy' ),
      'query' => 'recent',
      'count' => 5,
      'reverse' => 0,
    );
    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'query' ) ); ?>"><?php esc_html_e( 'Query:', 'magsy' ); ?></label>
      <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'query' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'query' ) ); ?>">
        <option value="recent" <?php selected( $instance['query'], 'recent' ); ?>>Most recent</option>
        <option value="liked" <?php selected( $instance['query'], 'liked' ); ?>>Most liked</option>
        <option value="commented" <?php selected( $instance['query'], 'commented' ); ?>>Most commented</option>
      </select>
    </p>

    <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Count:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['count'] ); ?>">
    </p>
    
    <p>
			<input class="checkbox" <?php checked( $instance['reverse'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'reverse' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'reverse' ) ); ?>" type="checkbox">
			<label for="<?php echo esc_attr( $this->get_field_id( 'reverse' ) ); ?>"><?php esc_html_e( 'Reverse?', 'magsy' ); ?></label>
		</p> <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['query'] = ( ! empty( $new_instance['query'] ) ) ? strip_tags( $new_instance['query'] ) : '';
    $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
    $instance['reverse'] = ( ! empty( $new_instance['reverse'] ) ) ? 1 : 0;

    return $instance;
  }

}