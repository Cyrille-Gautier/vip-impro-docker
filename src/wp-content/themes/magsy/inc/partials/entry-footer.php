<div class="entry-footer">
  <a href="<?php echo esc_url( get_the_permalink() ); ?>">
    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
      <?php
        if ( magsy_get_option( 'magsy_enable_human_readable_date', false ) == true ) {
          echo sprintf( _x( '%s ago', '%s = human-readable time difference', 'magsy' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
        } else {
          echo esc_html( get_the_date() );
        }
      ?>
    </time>
  </a>
</div>