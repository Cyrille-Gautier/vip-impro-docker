<?php function magsy_logo( $options = array() ) {
  $options = array_merge( array( 'contrary' => true ), $options );
  $logo_regular = magsy_get_option( 'magsy_logo_regular', '' );
  $logo_contrary = magsy_get_option( 'magsy_logo_contrary', '' ); ?>

  <div class="logo-wrapper">
    <?php if ( ! empty( $logo_regular ) ) : ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img class="logo regular" src="<?php echo esc_url( $logo_regular ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
      </a>
    <?php else : ?>
      <a class="logo text" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
    <?php endif; ?>

    <?php if ( $options['contrary'] && ! empty( $logo_contrary ) ) : ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img class="logo contrary" src="<?php echo esc_url( $logo_contrary ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
      </a>
    <?php endif; ?>
  </div> <?php
}