<?php

function magsy_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$navbar_style = magsy_get_option( 'magsy_navbar_style', 'sticky' );
	if ( is_singular( 'post' ) || is_page() ) {
  	$navbar_style = magsy_compare_options( $navbar_style, rwmb_meta( 'magsy_navbar_style' ) );
	}
	$classes[] = 'navbar-' . $navbar_style;

	if ( magsy_get_option( 'magsy_navbar_full', false ) == true ) {
		$classes[] = 'navbar-full';
	}

	if ( magsy_get_option( 'magsy_navbar_slide', false ) == true ) {
		$classes[] = 'navbar-slide';
	}

	if ( magsy_compare_options( magsy_get_option( 'magsy_navbar_hidden', false ), rwmb_meta( 'magsy_navbar_hidden' ) ) == true ) {
		$classes[] = 'navbar-hidden';
	}

	if ( magsy_get_option( 'magsy_disable_search', false ) == true ) {
		$classes[] = 'no-search';
	}

	$classes[] = 'sidebar-' . magsy_sidebar();

	if ( magsy_show_hero() ) {
		$classes[] = 'with-hero';

		if ( is_home() ) {
			$classes[] = 'hero-' . magsy_get_option( 'magsy_hero_home_style', 'none' );
			$classes[] = 'hero-' . magsy_get_option( 'magsy_hero_home_content', 'image' );
		} elseif ( is_singular( 'post' ) || is_page() ) {
			$classes[] = 'hero-' . magsy_compare_options( magsy_get_option( 'magsy_hero_single_style', 'none' ), rwmb_meta( 'magsy_hero_single_style' ) );
			$classes[] = get_post_format() ? 'hero-' . get_post_format() : 'hero-image';
		}
	}

	if ( magsy_side_thumbnail() ) {
		$classes[] = 'side-thumbnail';
	}

	$classes[] = 'pagination-' . magsy_get_option( 'magsy_pagination', 'infinite_button' );

	if ( get_previous_posts_link() ) {
		$classes[] = 'paged-previous';
	}

	if ( get_next_posts_link() ) {
		$classes[] = 'paged-next';
	}

	if ( magsy_show_ads( 'before_header' ) ) {
		$classes[] = 'ads-before-header';
	}

	if ( magsy_show_ads( 'after_header' ) ) {
		$classes[] = 'ads-after-header';
	}

	if ( ( is_singular( 'post' ) || is_page() ) && rwmb_meta( 'magsy_subheading') != '' ) {
		$classes[] = 'with-subheading';
	}

	if ( ! is_active_sidebar( 'off_canvas' ) ) {
		$classes[] = 'no-off-canvas';
	}

	if ( is_page_template( 'page-modular.php' ) ) {
		$classes[] = rwmb_meta( 'magsy_section_title_style' ) == '' ? 'modular-title-1' : 'modular-title-' . rwmb_meta( 'magsy_section_title_style' );
	}

	return $classes;
}
add_filter( 'body_class', 'magsy_body_classes' );

function magsy_opengraph_tags() {
  global $post;

  if ( is_singular( 'post' ) ) : ?>
    <meta property="og:title" content="<?php echo esc_attr( get_the_title() ); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
    <meta property="og:url" content="<?php echo esc_url( get_the_permalink() ); ?>">

    <?php
			$description = strip_tags( $post->post_content );
			$description = $description != '' ? substr( $description, 0, 200 ) : get_bloginfo( 'description' );
    ?>
    <meta property="og:description" content="<?php echo esc_attr( $description ); ?>">

    <?php if ( has_post_thumbnail() ) : ?>
      <meta property="og:image" content="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>">
    <?php endif;
  endif;
}
if ( magsy_get_option( 'magsy_disable_open_graph', false ) == false ) {
	add_action( 'wp_head', 'magsy_opengraph_tags' );
}

function magsy_get_option( $setting, $default ) {
	$options = get_option( 'magsy_admin_options', array() );
  $value = $default;

  if ( isset( $options[ $setting ] ) ) {
    $value = $options[ $setting ];
  }

  return $value;
}

function magsy_compare_options( $global, $override ) {
  if ( $global == $override || $override == '' ) {
    return $global;
  } else {
    return $override;
  }
}

function magsy_thumbnail_ratio( $image_size ) {
	$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );

	if ( $thumbnail ) {
		return $thumbnail[2] / $thumbnail[1] * 100 . '%';
	} else {
		return 0;	
	}
}

function magsy_is_gif() {
  if ( has_post_thumbnail() ) {
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
    $featured_image = $featured_image[0];

    $path_parts = pathinfo( $featured_image );
    $extension = $path_parts['extension'];

    return $extension == 'gif' ? true : false;
  }

  return false;
}

function magsy_side_thumbnail() {
	if ( ( is_singular( 'post' ) || is_page() ) && has_post_thumbnail() ) {
		$image_location = magsy_compare_options( magsy_get_option( 'magsy_featured_image_location', 'mixed' ), rwmb_meta( 'magsy_featured_image_location' ) );
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

		if ( ( ( $image_location == 'mixed' && $featured_image[2] > $featured_image[1] ) || $image_location == 'side' ) && ! get_post_format() ) {
			return true;
		}
	}

	return false;
}

function magsy_show_hero() {
	return
		( is_home() && ! is_paged() && magsy_get_option( 'magsy_hero_home_style', 'none' ) != 'none' ) ||
		( is_singular( 'post' ) || is_page() ) && magsy_compare_options( magsy_get_option( 'magsy_hero_single_style', 'none' ), rwmb_meta( 'magsy_hero_single_style' ) ) != 'none';
}

function magsy_show_ads( $location ) {
	$option = 'magsy_ads_' . $location . '_';

	return
		magsy_get_option( $option . 'style', 'none' ) != 'none' &&
		(
			( is_singular( 'post' ) && magsy_get_option( $option . 'hide_post', false ) == false ) ||
			( is_page() && magsy_get_option( $option . 'hide_page', false ) == false ) ||
			( ( is_archive() || is_search() ) && magsy_get_option( $option . 'hide_archive', false ) == false ) ||
			( is_home() && magsy_get_option( $option . 'hide_latest', false ) == false )
		);
}

function magsy_excerpt( $limit ) {
	if ( magsy_get_option( 'magsy_excerpt_link', false ) == true ) {
		echo wp_trim_words( get_the_content(), $limit, '<a class="excerpt-link" href="' . get_the_permalink() . '">' . magsy_get_option( 'magsy_excerpt_more', '' ) . '</a>' );
	} else {
		echo wp_trim_words( get_the_content(), $limit, '<span class="excerpt-more">' . magsy_get_option( 'magsy_excerpt_more', '' ) . '</span>' );
	}
}

function magsy_excerpt_length( $length ) {
	return magsy_get_option( 'magsy_excerpt_length', 12 );
}
add_filter( 'excerpt_length', 'magsy_excerpt_length', 999 );

function magsy_excerpt_more( $more ) {
	if ( magsy_get_option( 'magsy_excerpt_link', false ) == true ) {
		return '<a class="excerpt-link" href="' . get_the_permalink() . '">' . magsy_get_option( 'magsy_excerpt_more', '' ) . '</a>';
	} else {
		return '<span class="excerpt-more">' . magsy_get_option( 'magsy_excerpt_more', '' ) . '</span>';
	}
}
add_filter( 'excerpt_more', 'magsy_excerpt_more' );

function magsy_lazy_content_images( $content ) {
	global $post;
	
	$pattern ="/<img(.*?)src=(.*?)class=\"(.*?)\"(.*?)srcset=(.*?)>/i";
	$replacement = '<img$1src=$2class="$3 lazyload"$4data-srcset=$5>';
	$content = preg_replace( $pattern, $replacement, $content );

	return $content;
}
add_filter( 'the_content', 'magsy_lazy_content_images' );

function magsy_social_links() {
	return array(
    array( 'name' => 'Facebook', 'option' => 'facebook_url', 'icon' => 'facebook', 'color' => '#3b5998' ),
    array( 'name' => 'Twitter', 'option' => 'twitter_url', 'icon' => 'twitter', 'color' => '#1da1f2' ),
    array( 'name' => 'Instagram', 'option' => 'instagram_url', 'icon' => 'instagram', 'color' => '#e1306c' ),
    array( 'name' => 'Pinterest', 'option' => 'pinterest_url', 'icon' => 'pinterest', 'color' => '#bd081c' ),
    array( 'name' => 'Google+', 'option' => 'google_plus_url', 'icon' => 'google-plus', 'color' => '#dd4b39' ),
    array( 'name' => 'YouTube', 'option' => 'youtube_url', 'icon' => 'youtube-play', 'color' => '#ff0000' ),
    array( 'name' => 'Vimeo', 'option' => 'vimeo_url', 'icon' => 'vimeo', 'color' => '#1ab7ea' ),
    array( 'name' => 'Dribbble', 'option' => 'dribbble_url', 'icon' => 'dribbble', 'color' => '#ea4c89' ),
    array( 'name' => 'LinkedIn', 'option' => 'linkedin_url', 'icon' => 'linkedin', 'color' => '#0077b5' ),
    array( 'name' => 'Behance', 'option' => 'behance_url', 'icon' => 'behance', 'color' => '#1769ff' ),
    array( 'name' => 'Reddit', 'option' => 'reddit_url', 'icon' => 'reddit', 'color' => '#ff4500' ),
    array( 'name' => 'SoundCloud', 'option' => 'soundcloud_url', 'icon' => 'soundcloud', 'color' => '#ff8800' ),
    array( 'name' => 'Steam', 'option' => 'steam_url', 'icon' => 'steam', 'color' => '#000000' ),
    array( 'name' => 'Twitch', 'option' => 'twitch_url', 'icon' => 'twitch', 'color' => '#6441a5' ),
    array( 'name' => 'VK', 'option' => 'vk_url', 'icon' => 'vk-box', 'color' => '#45668e' ),
    array( 'name' => 'RSS', 'option' => 'rss_url', 'icon' => 'rss', 'color' => '#f26522' ),
  );
}

function magsy_sharing_links() {
	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'magsy_full_1160' );

	return array(
		'facebook' => array(
			'label' => esc_html__( 'Facebook', 'magsy' ),
			'icon' => 'facebook',
			'url' => 'https://www.facebook.com/sharer.php?u=' . urlencode( get_the_permalink() ),
		),
		'twitter' => array(
			'label' => esc_html__( 'Twitter', 'magsy' ),
			'icon' => 'twitter',
			'url' => 'https://twitter.com/intent/tweet?url=' . urlencode( get_the_permalink() ) . '&text=' . urlencode( get_the_title() ),
		),
		'google' => array(
			'label' => esc_html__( 'Google+', 'magsy' ),
			'icon' => 'google-plus',
			'url' => 'https://plus.google.com/share?url=' . urlencode( get_the_permalink() ) . '&text=' . urlencode( get_the_title() ),
		),
		'linkedin' => array(
			'label' => esc_html__( 'LinkedIn', 'magsy' ),
			'icon' => 'linkedin',
			'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() ),
		),
		'pinterest' => array(
			'label' => esc_html__( 'Pinterest', 'magsy' ),
			'icon' => 'pinterest',
			'url' => 'https://pinterest.com/pin/create/button/?url=' . urlencode( get_the_permalink() ) . '&media=' . urlencode( $featured_image[0] ) . '&description=' . urlencode( get_the_title() ),
		),
		'reddit' => array(
			'label' => esc_html__( 'Reddit', 'magsy' ),
			'icon' => 'reddit',
			'url' => 'https://reddit.com/submit?url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() ),
		),
		'tumblr' => array(
			'label' => esc_html__( 'Tumblr', 'magsy' ),
			'icon' => 'tumblr',
			'url' => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() ),
		),
		'vk' => array(
			'label' => esc_html__( 'VK', 'magsy' ),
			'icon' => 'vk',
			'url' => 'http://vk.com/share.php?url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() ),
		),
		'pocket' => array(
			'label' => esc_html__( 'Pocket', 'magsy' ),
			'icon' => 'pocket',
			'url' => 'https://getpocket.com/edit?url=' . urlencode( get_the_permalink() ),
		),
		'telegram' => array(
			'label' => esc_html__( 'Telegram', 'magsy' ),
			'icon' => 'telegram',
			'url' => 'https://t.me/share/url?url=' . urlencode( get_the_permalink() ) . '&text=' . urlencode( get_the_title() ),
		),
	);
}

function magsy_sidebar() {
	if ( is_singular( 'post' ) || ( is_page() && ! is_page_template( 'page-modular.php' ) ) ) {
		return magsy_compare_options( magsy_get_option( 'magsy_sidebar_single', 'none' ), rwmb_meta( 'magsy_sidebar_single' ) );
	} elseif ( is_archive() || is_search() ) {
		return magsy_get_option( 'magsy_sidebar_archive', 'none' );
	} elseif ( is_home() ) {
		return magsy_get_option( 'magsy_sidebar_home', 'none' );
	}

	return 'none';
}

function magsy_column_classes( $sidebar ) {
	$content_column_class = 'content-column col-lg-9';
	$sidebar_column_class = 'sidebar-column col-lg-3';

	if ( $sidebar == 'none' ) {
		$content_column_class = 'col-lg-12';
	}

	return array( $content_column_class, $sidebar_column_class );
}