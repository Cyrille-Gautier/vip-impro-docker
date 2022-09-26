<?php $data = magsy_social_links(); ?>

<div class="social-links">
  <?php foreach ( $data as $d ) : ?>

    <?php if ( magsy_get_option( 'magsy_' . $d['option'], '' ) != '' ) : ?>
      <a href="<?php echo esc_url( magsy_get_option( 'magsy_' . $d['option'], '' ) ); ?>" target="_blank" rel="noopener noreferrer">
        <i class="mdi mdi-<?php echo esc_attr( $d['icon'] ); ?>"></i>
      </a>
    <?php endif; ?>

  <?php endforeach; ?>
</div>