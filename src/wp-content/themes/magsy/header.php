<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php magsy_ads( array( 'location' => 'before_header' ) ); ?>

<div class="site">
	<?php
		get_template_part( 'inc/partials/navbar' );

		magsy_ads( array( 'location' => 'after_header' ) );

		if ( magsy_show_hero() ) {
			get_template_part( 'inc/partials/hero' );
		}

		if ( is_archive() || is_search() ) {
			get_template_part( 'inc/partials/term-bar' );
		}
	?>
	
	<div class="site-content">