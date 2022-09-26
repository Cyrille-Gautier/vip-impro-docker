<?php function magsy_ads( $options = array() ) {
  $options = array_merge( array( 'container' => true ), $options );
  $option = 'magsy_ads_' . $options['location'] . '_'; ?>

  <?php if ( magsy_show_ads( $options['location'] ) ) : ?>
    <div class="ads <?php echo esc_attr( $options['location'] ); ?>">
      <?php if ( $options['container'] ) : ?>
      <div class="container">
      <?php endif; ?>
        <?php if ( magsy_get_option( $option . 'style', 'none' ) == 'image' ) :
          if ( magsy_get_option( $option . 'link', '' ) == '' ) : ?>
            <img src="<?php echo esc_url( magsy_get_option( $option . 'image', '' ) ); ?>">
          <?php else : ?>
            <a href="<?php echo esc_url( magsy_get_option( $option . 'link', '' ) ); ?>"<?php echo magsy_get_option( $option . 'new_tab', false ) == false ? '' : ' target="_blank"'; ?>>
              <img src="<?php echo esc_url( magsy_get_option( $option . 'image', '' ) ); ?>">
            </a>
          <?php endif;
        elseif ( magsy_get_option( $option . 'style', 'none' ) == 'html' ) :
          echo magsy_get_option( $option . 'html', '' );
        endif; ?>
      <?php if ( $options['container'] ) : ?>
      </div>
      <?php endif; ?>
    </div> <?php
  endif;
}