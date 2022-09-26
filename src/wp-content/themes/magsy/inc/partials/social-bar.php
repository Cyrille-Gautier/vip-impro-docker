<?php $data = magsy_social_links(); ?>

<div class="social-bar">
  <?php foreach ( $data as $d ) : ?>

    <?php if ( magsy_get_option( 'magsy_' . $d['option'], '' ) != '' ) : ?>
      <a href="<?php echo esc_url( magsy_get_option( 'magsy_' . $d['option'], '' ) ); ?>" target="_blank">
        <i class="mdi mdi-<?php echo esc_attr( $d['icon'] ); ?>" style="color: <?php echo esc_attr( $d['color'] ); ?>;"></i>
        <span class="hidden-xs hidden-sm"><?php echo esc_html( $d['name'] ); ?></span>
      </a>
    <?php endif; ?>

  <?php endforeach; ?>
</div>