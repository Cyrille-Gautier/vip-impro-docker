<?php if ( is_home() ) {
  $style = magsy_get_option( 'magsy_hero_home_style', 'none' );
  $content = magsy_get_option( 'magsy_hero_home_content', 'image' );
  $heading = magsy_get_option( 'magsy_hero_home_heading', '' );
  $subheading = magsy_get_option( 'magsy_hero_home_subheading', '' );
  $button_secondary_text = magsy_get_option( 'magsy_hero_home_button_secondary_text', '' );
  $button_secondary_link = magsy_get_option( 'magsy_hero_home_button_secondary_link', '' );
  $button_primary_text = magsy_get_option( 'magsy_hero_home_button_primary_text', '' );
  $button_primary_link = magsy_get_option( 'magsy_hero_home_button_primary_link', '' );
  $bg_image = magsy_get_option( 'magsy_hero_home_bg_image', '' );
  $bg_slider = array();
  $slides = magsy_get_option( 'magsy_hero_home_bg_slider', false );
  if ( $slides ) {
    foreach ( $slides as $slide ) {
      $image = wp_get_attachment_image_src( $slide['slider_image'], 'full' );
      $bg_slider[] = array(
        'image' => $image[0],
        'heading' => $slide['slider_heading'],
        'subheading' => $slide['slider_subheading'],
      );
    }
  }
} elseif ( is_singular( 'post' ) || is_page() ) {
  $style = magsy_compare_options( magsy_get_option( 'magsy_hero_single_style', 'none' ), rwmb_meta( 'magsy_hero_single_style' ) );
  $content = get_post_format() ? get_post_format() : 'image';
  $heading = rwmb_meta( 'magsy_hero_single_heading' ) == '' ? get_the_title() : rwmb_meta( 'magsy_hero_single_heading' );
  $subheading = rwmb_meta( 'magsy_hero_single_subheading' );
  $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
  $bg_image = $bg_image[0];
  $bg_slider = array();
  $slides = rwmb_meta( 'magsy_pf_gallery_data' );
  if ( ! empty( $slides ) ) {
    foreach ( $slides as $slide ) {
      $image = wp_get_attachment_image_src( $slide['ID'], 'full' );
      $bg_slider[] = array(
        'image' => $image[0],
        'heading' => get_the_title(),
        'subheading' => '',
      );
    }
  }
}

$hero_class = 'hero lazyload visible';
$container_class = 'container';
$sidebar = magsy_sidebar();

if (
  ( ! is_home() && ! is_page_template( 'page-modular.php' ) && is_page() ) ||
  ( is_singular( 'post' ) && $content != 'video' && $content != 'audio' && $sidebar == 'none' )
) {
  $container_class .= ' small';
}

if ( $content == 'gallery' ) {
  $hero_class = 'hero';
  $bg_image = '';
} ?>

<div class="<?php echo esc_attr( $hero_class ); ?>" data-bg="<?php echo esc_url( $bg_image ); ?>">
  <?php if ( $content == 'image' && $heading != '' && ! is_singular( 'post' ) ) : ?>
    <div class="<?php echo esc_attr( $container_class ); ?>">
      <header class="entry-header">
        <?php if ( $heading != '' ) : ?>
          <h1 class="hero-heading"><?php echo esc_html( $heading ); ?></h1>
        <?php endif; ?>
        <?php if ( $subheading != '' ) : ?>
          <div class="hero-subheading"><?php echo esc_html( $subheading ); ?></div>
        <?php endif; ?>
      </header>
    </div>
  <?php elseif ( is_singular( 'post' ) && $content != 'video' && $content != 'audio' ) : ?>
    <div class="<?php echo esc_attr( $container_class ); ?>">
      <?php magsy_entry_header( array( 'tag' => 'h1', 'link' => false, 'white' => true, 'author' => true, 'category' => true, 'date' => true ) ); ?>
    </div>
  <?php endif; ?>

  <?php if ( $content == 'gallery' && $bg_slider ) : ?>
    <div class="hero-slider owl nav-transparent">
      <?php foreach ( $bg_slider as $slide ) : ?>
        <div class="slider-item lazyload visible" data-bg="<?php echo esc_url( $slide['image'] ); ?>">
          <?php if ( $slide['heading'] != '' && ! is_singular( 'post' ) ) : ?>
            <div class="container">
              <header class="entry-header">
                <h2 class="hero-heading"><?php echo esc_html( $slide['heading'] ); ?></h2>
                <div class="hero-subheading"><?php echo esc_html( $slide['subheading'] ); ?></div>
              </header>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ( ( is_singular( 'post' ) || is_page() ) && ( $content == 'video' || $content == 'audio' ) ) :
    echo '<div class="hero-media"><div class="container">' . rwmb_meta( 'magsy_pf_' . get_post_format() . '_data' ) . '</div></div>';
  endif; ?>
</div>