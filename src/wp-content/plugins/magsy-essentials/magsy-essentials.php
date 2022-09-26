<?php
/*
Plugin Name: Magsy Essentials
Description: The main plugin for Magsy.
Version: 1.3
Author: MondoTheme
Author URI: http://themeforest.net/user/mondotheme/portfolio
*/

class Magsy_Essentials {

  public function __construct() {
    add_action( 'wp_ajax_magsy_like', array( $this, 'magsy_like' ) );
    add_action( 'wp_ajax_nopriv_magsy_like', array( $this, 'magsy_like' ) );
    add_action( 'wp_ajax_magsy_unlike', array( $this, 'magsy_unlike' ) );
    add_action( 'wp_ajax_nopriv_magsy_unlike', array( $this, 'magsy_unlike' ) );
    add_action( 'widgets_init', array( $this, 'magsy_register_widgets' ) );
    if ( $this->magsy_get_option( 'magsy_enable_standard_widgets', false ) == false ) {
      add_action( 'sidebars_widgets', array( $this, 'magsy_limit_widgets' ) );
    }
    add_action( 'category_add_form_fields', array( $this, 'magsy_add_category_field' ) );
    add_action( 'category_edit_form_fields', array( $this, 'magsy_edit_category_field' ) );
    add_action( 'created_category', array( $this, 'magsy_save_category_field' ) );
    add_action( 'edited_category', array( $this, 'magsy_save_category_field' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'magsy_category_script' ) );
    add_action( 'admin_print_scripts', array( $this, 'magsy_category_init' ), 20 );
    add_filter( 'user_contactmethods', array( $this, 'magsy_add_links_to_author_profile' ), 10, 1 );
    add_action( 'pt-ocdi/before_widgets_import', array( $this, 'magsy_before_widgets_import' ) );
    add_filter( 'pt-ocdi/import_files', array( $this, 'magsy_import_demo' ) );
    add_filter( 'pt-ocdi/after_import', array( $this, 'magsy_after_import' ) );
    add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
  }

  public static function magsy_entry_action() {
    $like_count = get_post_meta( get_the_ID(), 'magsy_like', true );
    $like_button_text = $like_count != '' ? $like_count : '0';
  
    $view_count = get_post_meta( get_the_ID(), 'magsy_view', true );
    $view_button_text = $view_count != '' ? $view_count : '0';
    
    $options = magsy_get_option( 'magsy_sharing_links', array( 'facebook', 'twitter', 'google', 'pinterest' ) );
    $links = magsy_sharing_links(); ?>
    
    <div class="entry-action">
      <div class="action-count">
        <a class="like" data-id="<?php echo esc_attr( get_the_ID() ); ?>" href="#"><span class="icon"><i class="mdi mdi-thumb-up"></i></span><span class="count"><?php echo esc_html( $like_button_text ); ?></span><span>&nbsp;<?php printf( _n( 'like', 'likes', esc_html( $like_count ), 'magsy' ), esc_html( number_format_i18n( floatval( $like_count ) ) ) ); ?></span></a>
        <a class="view" href="<?php echo esc_url( get_the_permalink() ) ?>"><span class="icon"><i class="mdi mdi-eye"></i></span><span class="count"><?php echo esc_html( $view_button_text ); ?></span><span>&nbsp;<?php printf( _n( 'view', 'views', esc_html( $view_count ), 'magsy' ), esc_html( number_format_i18n( floatval( $view_count ) ) ) ); ?></span></a>
        <a class="comment" href="<?php echo esc_url( get_the_permalink() . '#comments' ) ?>"><span class="icon"><i class="mdi mdi-comment"></i></span><span class="count"><?php echo get_comments_number(); ?></span><span>&nbsp;<?php printf( _n( 'comment', 'comments', esc_html( get_comments_number() ), 'magsy' ), esc_html( number_format_i18n( get_comments_number() ) ) ); ?></span></a>
      </div>
      <div class="action-share">
        <?php foreach ( $links as $i => $v ) : ?>
          <?php if ( in_array( $i, $options ) ) : ?>
            <a class="<?php echo esc_attr( $i ); ?>" href="<?php echo esc_url( $v['url'] ); ?>" target="_blank">
              <i class="mdi mdi-<?php echo esc_attr( $v['icon'] ); ?>"></i>
            </a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div> <?php
  }

  public function magsy_like() {
    check_ajax_referer( 'magsy_like_nonce', 'nonce' );
  
    $post_id = $_POST['post_id'];
    $current_count = get_post_meta( $post_id, 'magsy_like', true );
    
    if ( $current_count == '' ) {
      $current_count = 0;
    }
  
    $updated_count = $current_count + 1;
    update_post_meta( $post_id, 'magsy_like', $updated_count );
  
    wp_die( (string) $updated_count );
  }
  
  public function magsy_unlike() {
    check_ajax_referer( 'magsy_unlike_nonce', 'nonce' );
  
    $post_id = $_POST['post_id'];
    $current_count = get_post_meta( $post_id, 'magsy_like', true );
  
    if ( $current_count == '' || $current_count == '0' ) {
      $current_count = 1;
    }
  
    $updated_count = $current_count - 1;
  
    if ( $updated_count >= 0 ) {
      update_post_meta( $post_id, 'magsy_like', $updated_count );
    }
  
    wp_die( (string) $updated_count );
  }
  
  public static function magsy_view() {
    $post_id = get_the_ID();
    $current_count = get_post_meta( $post_id, 'magsy_view', true );
  
    if ( $current_count == '' ) {
      $current_count = 0;
    }
  
    if ( ! is_user_logged_in() ) {
      $current_count = $current_count + 1;
    }
  
    update_post_meta( $post_id, 'magsy_view', $current_count );
  }

  public function magsy_register_widgets() {
    require_once 'modules/module_post_base.php';
    require_once 'modules/module_post_carousel.php';
    require_once 'modules/module_post_grid.php';
    require_once 'modules/module_post_masonry.php';
    require_once 'modules/module_post_big_list.php';
    require_once 'modules/module_post_list.php';
    require_once 'modules/module_post_big_2.php';
    require_once 'modules/module_post_big_3.php';
    require_once 'modules/module_slider_big.php';
    require_once 'modules/module_slider_center.php';
    require_once 'modules/module_slider_thumbnail.php';
    require_once 'modules/module_parallax.php';
    require_once 'modules/module_category_boxes.php';
    require_once 'modules/module_image.php';

    register_widget( 'Magsy_Post_Carousel_Module' );
    register_widget( 'Magsy_Post_Grid_Module' );
    register_widget( 'Magsy_Post_Masonry_Module' );
    register_widget( 'Magsy_Post_Big_List_Module' );
    register_widget( 'Magsy_Post_List_Module' );
    register_widget( 'Magsy_Post_Big_2_Module' );
    register_widget( 'Magsy_Post_Big_3_Module' );
    register_widget( 'Magsy_Slider_Big_Module' );
    register_widget( 'Magsy_Slider_Center_Module' );
    register_widget( 'Magsy_Slider_Thumbnail_Module' );
    register_widget( 'Magsy_Parallax_Module' );
    register_widget( 'Magsy_Category_Boxes_Module' );
    register_widget( 'Magsy_Image_Module' );

    require_once 'widgets/widget_about.php';
    require_once 'widgets/widget_category.php';
    require_once 'widgets/widget_facebook.php';
    require_once 'widgets/widget_picks.php';
    require_once 'widgets/widget_posts.php';
    require_once 'widgets/widget_promo.php';
    require_once 'widgets/widget_social.php';

    register_widget( 'Magsy_About_Widget' );
    register_widget( 'Magsy_Category_Widget' );
    register_widget( 'Magsy_Facebook_Widget' );
    register_widget( 'Magsy_Picks_Widget' );
    register_widget( 'Magsy_Posts_Widget' );
    register_widget( 'Magsy_Promo_Widget' );
    register_widget( 'Magsy_Social_Widget' );
  }

  function magsy_limit_widgets( $sidebars_widgets ) {
    if ( ! empty( $sidebars_widgets['modules'] ) ) {
      foreach ( $sidebars_widgets['modules'] as $k => $v ) {
        if ( substr( $v, 0, 12 ) != 'magsy_module' && substr( $v, 0, 14 ) != 'null-instagram' && substr( $v, 0, 11 ) != 'custom_html' && substr( $v, 0, 11 ) != 'media_video' ) {
          unset( $sidebars_widgets['modules'][ $k ] );
        }
      }
    }

    if ( ! empty( $sidebars_widgets['sidebar'] ) ) {
      foreach ( $sidebars_widgets['sidebar'] as $k => $v ) {
        if ( substr( $v, 0, 12 ) == 'magsy_module' ) {
          unset( $sidebars_widgets['sidebar'][ $k ] );
        }
      }
    }

    return $sidebars_widgets;
  }

  function magsy_add_category_field() { ?>
    <div class="form-field term-color-wrap">
      <label for="category-color"><?php echo esc_html__( 'Color', 'magsy' ); ?></label>
      <input name="color" class="colorpicker" id="category-color">
    </div>
    
    <div class="form-field term-image-wrap">
      <label for="category-image"><?php echo esc_html__( 'Image', 'magsy' ); ?></label>
      <input name="image" class="imageurl" id="category-image" type="text">
      <input class="button imagepicker" type="button" value="<?php echo esc_attr__( 'Select Image', 'magsy' ); ?>">
    </div> <?php
  }

  function magsy_edit_category_field( $term ) {
    $color = get_term_meta( $term->term_id, 'category_color', true );
    $image = get_term_meta( $term->term_id, 'category_image', true ); ?>

    <tr class="form-field term-color-wrap">
      <th scope="row"><?php echo esc_html__( 'Color', 'magsy' ); ?></th>
      <td><input name="color" class="colorpicker" id="category-color" value="<?php echo esc_attr( $color ); ?>"></td>
    </tr>
    
    <tr class="form-field term-image-wrap">
      <th scope="row"><?php echo esc_html__( 'Image', 'magsy' ); ?></th>
      <td>
        <input name="image" class="imageurl" id="category-image" type="text" value="<?php echo esc_url( $image ); ?>">
        <input class="button imagepicker" type="button" value="<?php echo esc_attr__( 'Select Image', 'magsy' ); ?>">
      </td>
    </tr> <?php
  }

  function magsy_save_category_field( $term_id ) {
    if ( ( isset( $_POST['color'] ) && ! empty( $_POST['color'] ) ) || ( isset( $_POST['image'] ) && ! empty( $_POST['image'] ) ) ) {
      if ( isset( $_POST['color'] ) && ! empty( $_POST['color'] ) )
        update_term_meta( $term_id, 'category_color', $_POST['color'] );
      if ( isset( $_POST['image'] ) && ! empty( $_POST['image'] ) )
        update_term_meta( $term_id, 'category_image', $_POST['image'] );
    } else {
      delete_term_meta( $term_id, 'category_color' );
      delete_term_meta( $term_id, 'category_image' );
    }
  }

  function magsy_category_script() {
    if ( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) {
      return;
    }
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_media();
  }

  function magsy_category_init() {
    if ( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) {
      return;
    } ?>

    <script>
      jQuery(document).ready(function() {
        jQuery('.colorpicker').wpColorPicker();

        jQuery('.imagepicker').on('click', function(e) {
          e.preventDefault();
          var clickedElement = jQuery(this);
          var image = wp.media().open()
          .on('select', function(e) {
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            clickedElement.prev('.imageurl').val(image_url);
          });
        });
      });
    </script> <?php
  }

  public function magsy_add_links_to_author_profile( $contactmethods ) {
    $contactmethods['facebook'] = esc_html__( 'Facebook', 'magsy' );
    $contactmethods['twitter'] = esc_html__( 'Twitter', 'magsy' );
    $contactmethods['instagram'] = esc_html__( 'Instagram', 'magsy' );
    $contactmethods['printerest'] = esc_html__( 'Pinterest', 'magsy' );
    $contactmethods['google'] = esc_html__( 'Google+', 'magsy' );
    $contactmethods['linkedin'] = esc_html__( 'LinkedIn', 'magsy' );

    return $contactmethods;
  }

  public function magsy_before_widgets_import( $selected_import ) {
    register_sidebar( array(
      'name' => esc_html__( 'Version 2', 'magsy' ),
      'id' => 'version-2',
      'description' => esc_html__( 'Add modules here.', 'magsy' ),
      'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
      'after_widget' => '</div></div>',
      'before_title' => '<h3 class="section-title"><span>',
      'after_title' => '</span></h3>',
    ) );
    register_sidebar( array(
      'name' => esc_html__( 'Version 3', 'magsy' ),
      'id' => 'version-3',
      'description' => esc_html__( 'Add modules here.', 'magsy' ),
      'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
      'after_widget' => '</div></div>',
      'before_title' => '<h3 class="section-title"><span>',
      'after_title' => '</span></h3>',
    ) );
    register_sidebar( array(
      'name' => esc_html__( 'Version 4', 'magsy' ),
      'id' => 'version-4',
      'description' => esc_html__( 'Add modules here.', 'magsy' ),
      'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
      'after_widget' => '</div></div>',
      'before_title' => '<h3 class="section-title"><span>',
      'after_title' => '</span></h3>',
    ) );
    register_sidebar( array(
      'name' => esc_html__( 'Version 5', 'magsy' ),
      'id' => 'version-5',
      'description' => esc_html__( 'Add modules here.', 'magsy' ),
      'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
      'after_widget' => '</div></div>',
      'before_title' => '<h3 class="section-title"><span>',
      'after_title' => '</span></h3>',
    ) );
    register_sidebar( array(
      'name' => esc_html__( 'Version 6', 'magsy' ),
      'id' => 'version-6',
      'description' => esc_html__( 'Add modules here.', 'magsy' ),
      'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
      'after_widget' => '</div></div>',
      'before_title' => '<h3 class="section-title"><span>',
      'after_title' => '</span></h3>',
    ) );
    register_sidebar( array(
      'name' => esc_html__( 'Version 7', 'magsy' ),
      'id' => 'version-7',
      'description' => esc_html__( 'Add modules here.', 'magsy' ),
      'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
      'after_widget' => '</div></div>',
      'before_title' => '<h3 class="section-title"><span>',
      'after_title' => '</span></h3>',
    ) );
  }

  public function magsy_import_demo() {
    return array(
      array(
        'import_file_name' => esc_html__( 'Main Demo', 'magsy' ),
        'import_file_url' => 'https://s3.us-east-2.amazonaws.com/mondotheme/magsy/demo.xml',
        'import_widget_file_url' => 'https://s3.us-east-2.amazonaws.com/mondotheme/magsy/demo.wie',
        'import_customizer_file_url' => 'https://s3.us-east-2.amazonaws.com/mondotheme/magsy/demo.dat',
        'import_preview_image_url' => 'https://s3.us-east-2.amazonaws.com/mondotheme/magsy/demo.jpg',
        'preview_url' => 'https://magsy.mondotheme.com',
      ),
    );
  }

  public function magsy_after_import() {
    $main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array( 'menu-1' => $main_menu->term_id ) );

    $footer_menu = get_term_by( 'name', 'Footer', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array( 'menu-2' => $footer_menu->term_id ) );

    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Latest' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
  }

  protected function magsy_get_option( $setting, $default ) {
    $options = get_option( 'magsy_admin_options', array() );
    $value = $default;

    if ( isset( $options[ $setting ] ) ) {
      $value = $options[ $setting ];
    }

    return $value;
  }

}

$magsy_essentials = new Magsy_Essentials();