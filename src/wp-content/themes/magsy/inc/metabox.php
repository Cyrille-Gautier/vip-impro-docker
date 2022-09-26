<?php function magsy_register_meta_boxes( $meta_boxes ) {
  $prefix = 'magsy_';
  
  $meta_boxes[] = array(
    'id' => 'general_settings',
    'title' => esc_html__( 'General Settings', 'magsy' ),
    'pages' => array( 'post', 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,
    'fields' => array(
      array(
        'name' => esc_html__( 'Navbar style', 'magsy' ),
        'id' => "{$prefix}navbar_style",
        'type' => 'select',
        'options' => array(
          'sticky' => esc_html__( 'Sticky', 'magsy' ),
          'transparent' => esc_html__( 'Transparent', 'magsy' ),
          'sticky_transparent' => esc_html__( 'Sticky+Transparent', 'magsy' ),
          'regular' => esc_html__( 'Regular', 'magsy' ),
        ),
        'multiple' => false,
        'placeholder' => esc_html__( 'Same as customizer', 'magsy' ),
      ),
      array(
        'name' => esc_html__( 'Hidden main menu', 'magsy' ),
        'id' => "{$prefix}navbar_hidden",
        'type' => 'select',
        'options' => array(
          '1' => esc_html__( 'Yes', 'magsy' ),
          '0' => esc_html__( 'No', 'magsy' ),
        ),
        'multiple' => false,
        'placeholder' => esc_html__( 'Same as customizer', 'magsy' ),
      ),
      array(
        'name' => esc_html__( 'Sidebar style', 'magsy' ),
        'id' => "{$prefix}sidebar_single",
        'type' => 'select',
        'options' => array(
          'none' => esc_html__( 'No sidebar', 'magsy' ),
          'right' => esc_html__( 'Right sidebar', 'magsy' ),
          'left' => esc_html__( 'Left sidebar', 'magsy' ),
        ),
        'multiple' => false,
        'placeholder' => esc_html__( 'Same as customizer', 'magsy' ),
      ),
      array(
        'name' => esc_html__( 'Featured image location', 'magsy' ),
        'id' => "{$prefix}featured_image_location",
        'type' => 'select',
        'options' => array(
          'mixed' => esc_html__( 'Mixed', 'magsy' ),
          'side' => esc_html__( 'On side', 'magsy' ),
          'with' => esc_html__( 'With content', 'magsy' ),
        ),
        'multiple' => false,
        'placeholder' => esc_html__( 'Same as customizer', 'magsy' ),
      ),
      array(
        'name' => esc_html__( 'Make featured image smaller', 'magsy' ),
        'id' => "{$prefix}small_featured_image",
        'type' => 'select',
        'options' => array(
          '1' => esc_html__( 'Yes', 'magsy' ),
          '0' => esc_html__( 'No', 'magsy' ),
        ),
        'multiple' => false,
        'placeholder' => esc_html__( 'Same as customizer', 'magsy' ),
      ),
      array(
        'name' => esc_html__( 'Subheading', 'magsy' ),
        'id' => "{$prefix}subheading",
        'type' => 'textarea',
        'cols' => 20,
        'rows' => 4,
      ),
    )
  );

  $meta_boxes[] = array(
    'id' => 'hero_settings_post',
    'title' => esc_html__( 'Hero Settings', 'magsy' ),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,
    'fields' => array(
      array(
        'name' => esc_html__( 'Hero style', 'magsy' ),
        'id' => "{$prefix}hero_single_style",
        'type' => 'select',
        'options' => array(
          'wide' => esc_html__( 'Wide', 'magsy' ),
          'full' => esc_html__( 'Full', 'magsy' ),
          'none' => esc_html__( 'None', 'magsy' ),
        ),
        'multiple' => false,
        'placeholder' => esc_html__( 'Same as customizer', 'magsy' ),
      ),
    )
  );

  $meta_boxes[] = array(
    'id' => 'hero_settings_page',
    'title' => esc_html__( 'Hero Settings', 'magsy' ),
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,
    'fields' => array(
      array(
        'name' => esc_html__( 'Hero style', 'magsy' ),
        'id' => "{$prefix}hero_single_style",
        'type' => 'select',
        'options' => array(
          'wide' => esc_html__( 'Wide', 'magsy' ),
          'full' => esc_html__( 'Full', 'magsy' ),
          'none' => esc_html__( 'None', 'magsy' ),
        ),
        'multiple' => false,
        'placeholder' => esc_html__( 'Same as customizer', 'magsy' ),
      ),
      array(
        'name' => esc_html__( 'Hero heading', 'magsy' ),
        'id' => "{$prefix}hero_single_heading",
        'type' => 'text',
      ),
      array(
        'name' => esc_html__( 'Hero subheading', 'magsy' ),
        'id' => "{$prefix}hero_single_subheading",
        'type' => 'text',
      ),
    )
  );

  $meta_boxes[] = array(
    'id' => 'modular_page_settings',
    'title' => esc_html__( 'Modular Page Settings', 'magsy' ),
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,
    'fields' => array(
      array(
        'name' => esc_html__( 'Section title style', 'magsy' ),
        'id' => "{$prefix}section_title_style",
        'type' => 'select',
        'options' => array(
          '1' => esc_html__( 'Style 1', 'magsy' ),
          '2' => esc_html__( 'Style 2', 'magsy' ),
          '3' => esc_html__( 'Style 3', 'magsy' ),
        ),
        'multiple' => false,
      ),
    )
  );

  $meta_boxes[] = array(
    'id' => 'format_settings',
    'title' => esc_html__( 'Post Format Settings', 'magsy' ),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,
    'fields' => array(
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Video Format', 'magsy' ),
        'id' => 'heading_id',
      ),
      array(
        'name' => esc_html__( 'Video embed code', 'magsy' ),
        'id' => "{$prefix}pf_video_data",
        'type' => 'textarea',
        'cols' => 20,
        'rows' => 4,
      ),
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Gallery Format', 'magsy' ),
        'id' => 'heading_id',
      ),
      array(
        'name' => esc_html__( 'Gallery images', 'magsy' ),
        'id' => "{$prefix}pf_gallery_data",
        'type' => 'image_advanced',
        'max_file_uploads' => 100,
      ),
      array(
        'name' => esc_html__( 'Gallery style', 'magsy' ),
        'id' => "{$prefix}pf_gallery_style",
        'type' => 'select',
        'options' => array(
          'slider' => esc_html__( 'Slider', 'magsy' ),
          'justified' => esc_html__( 'Justified', 'magsy' ),
        ),
        'multiple' => false,
      ),
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Audio Format', 'magsy' ),
        'id' => 'heading_id',
      ),
      array(
        'name' => esc_html__( 'Audio embed code', 'magsy' ),
        'id' => "{$prefix}pf_audio_data",
        'type' => 'textarea',
        'cols' => 20,
        'rows' => 4,
      ),
    )
  );

  return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'magsy_register_meta_boxes' );