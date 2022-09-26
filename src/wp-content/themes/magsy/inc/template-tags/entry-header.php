<?php function magsy_entry_header( $options = array() ) {
  $options = array_merge( array( 'outside_loop' => false, 'container' => 'header', 'tag' => 'h2', 'link' => true, 'white' => false, 'author' => false, 'category' => false, 'date' => false, 'comment' => false, 'like' => false ), $options );
  $queried_object = get_queried_object();
  $post_id = $options['outside_loop'] ? $queried_object->ID : get_the_ID();
  $categories = get_the_category( $post_id ); ?>

  <?php echo '<' . $options['container'] . ' class="entry-header' . esc_attr( $options['white'] ? ' white' : '' ) . '">'; ?>
    <?php if ( $options['author'] || $options['category'] || $options['date'] || $options['comment'] || $options['like'] ) : ?>
      <div class="entry-meta">
        <?php if ( $options['author'] ) :
          $author_id = get_post_field( 'post_author', $post_id ); ?>
          <span class="meta-author">
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ); ?>">
              <?php
                echo get_avatar( get_the_author_meta( 'email', $author_id ), '40', null, get_the_author_meta( 'display_name', $author_id ) );
                echo get_the_author_meta( 'display_name', $author_id );
              ?>
            </a>
          </span>
        <?php endif;

        if ( $categories && $options['category'] ) : ?>
          <span class="meta-category">
            <?php foreach ( $categories as $category ) :
              $color = get_term_meta( $category->term_id, 'category_color', true ); ?>
              <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" rel="category">
                <?php if ( $color != '' ) : ?>
                  <i class="dot" style="background-color: <?php echo esc_attr( $color ); ?>;"></i>
                <?php endif;
                echo esc_html( $category->name ); ?>
              </a>
            <?php endforeach; ?>
          </span>
        <?php endif;

        if ( $options['date'] ) : ?>
          <span class="meta-date">
            <a href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
              <time datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
                <?php
                  if ( magsy_get_option( 'magsy_enable_human_readable_date', false ) == true ) {
                    echo sprintf( _x( '%s ago', '%s = human-readable time difference', 'magsy' ), human_time_diff( get_the_time( 'U', $post_id ), current_time( 'timestamp' ) ) );
                  } else {
                    echo esc_html( get_the_date( null, $post_id ) );
                  }
                ?>
              </time>
            </a>
          </span>
        <?php endif;
        
        if ( $options['comment'] && ! post_password_required( $post_id ) && ( comments_open( $post_id ) || get_comments_number( $post_id ) ) ) : ?>
          <span class="meta-comment">
            <a href="<?php echo esc_url( get_the_permalink( $post_id ) . '#comments' ); ?>">
              <?php printf( _n( '%s comment', '%s comments', esc_html( get_comments_number( $post_id ) ), 'magsy' ), esc_html( number_format_i18n( get_comments_number( $post_id ) ) ) ); ?>
            </a>
          </span>
        <?php endif;

        if ( $options['like'] ) :
          $like_count = get_post_meta( $post_id, 'magsy_like', true );
          $like_count = $like_count != '' ? $like_count : '0';
          printf( _n( '%s like', '%s likes', esc_html( $like_count ), 'magsy' ), esc_html( number_format_i18n( $like_count ) ) );
        endif; ?>
      </div>
    <?php endif; ?>

    <?php
      if ( $options['link'] ) {
        echo '<' . $options['tag'] . ' class="entry-title"><a href="' . esc_url( get_permalink( $post_id ) ) . '" rel="bookmark">' . get_the_title( $post_id ) . '</a></' . $options['tag'] . '>';
      } else {
        echo '<' . $options['tag'] . ' class="entry-title">' . get_the_title( $post_id ) . '</' . $options['tag'] . '>';
      }
    ?>
  <?php echo '</' . $options['container'] . '>';
}