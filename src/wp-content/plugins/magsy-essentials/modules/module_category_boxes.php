<?php

class Magsy_Category_Boxes_Module extends WP_Widget {

	protected $categories;

	public function __construct() {
		parent::__construct(
			'magsy_module_category_boxes',
			esc_html__( 'Magsy Module: Category Boxes', 'magsy' ),
			array( 'description' => esc_html__( 'Displays category boxes.', 'magsy' ) )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$order = isset( $instance['order'] ) ? $instance['order'] : '';

		if ( $order == '' ) {
			$slugs = isset( $instance['slugs'] ) ? explode( ',', $instance['slugs'] ) : '';
		} else {
			$cats_by_ids = get_categories( array(
				'include' => $order,
				'orderby' => 'include',
			) );
			$slugs = array();
			
			foreach ( $cats_by_ids as $cat ) {
				$slugs[] = $cat->slug;
			}
		}

		$random_thumbnails = ! empty( $instance['random_thumbnails'] ) ? 1 : 0;

		echo $before_widget;
    if ( ! empty( $title ) ) {
      echo $before_title . $title . $after_title;
		}
		
		ob_start();

		if ( $slugs[0] != '' ) : ?>
			<div class="module category-boxes owl">
				<?php foreach ( $slugs as $slug ) : ?>
					<div class="category-box">
						<?php $category = get_category_by_slug( $slug );
						$args = array( 'category_name' => $slug, 'posts_per_page' => 3 );
						$random_thumbnails ? $args['orderby'] = 'rand' : '';
						$category_posts = get_posts( $args );
						$thumbnails = array();
						$index = 0;
						
						foreach ( $category_posts as $category_post ) :
							$thumbnails[] = $index == 0 ? get_the_post_thumbnail_url( $category_post, 'magsy_full_400' ) : get_the_post_thumbnail_url( $category_post, 'thumbnail' );
							$index++;
						endforeach; ?>

						<div class="entry-thumbnails">
							<div class="big thumbnail">
								<img class="lazyload" data-src="<?php echo esc_url( $thumbnails[0] ); ?>">
							</div>
							<div class="small">
								<div class="thumbnail">
									<img class="lazyload" data-src="<?php echo esc_url( $thumbnails[1] ); ?>">
								</div>
								<div class="thumbnail">
									<img class="lazyload" data-src="<?php echo esc_url( $thumbnails[2] ); ?>">
									<?php if ( $category->category_count > 3 ) : ?>
										<span>+<?php echo esc_html( $category->category_count - 3 ); ?></span>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<h3 class="entry-title"><?php echo esc_html( $category->name ); ?></h3>
						<a class="u-permalink" href="<?php echo esc_url( get_category_link( $category->cat_ID ) ); ?>"></a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif;

		echo ob_get_clean();
		echo $after_widget;
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => '',
			'slugs' => '',
			'order' => '',
			'random_thumbnails' => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$slugs = explode( ',', $instance['slugs'] );
		$categories = get_categories(); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<?php foreach ( $categories as $category ) : ?>
			<p>
				<input class="checkbox" <?php if ( in_array( $category->slug, $slugs ) ) echo 'checked="checked"'; ?> id="<?php echo esc_attr( $this->get_field_id( 'slugs' ) . $category->term_id ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slugs' ) ); ?>[]" type="checkbox" value="<?php echo esc_attr( $category->slug ); ?>">
				<label for="<?php echo esc_attr( $this->get_field_id( 'slugs' ) . $category->term_id ); ?>"><?php echo esc_html( $category->name ) . ' (' . esc_html__( 'ID:', 'magsy' ) . ' ' . $category->term_id . ')'; ?></label>
			</p>
		<?php endforeach; ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Custom order (IDs separated by commas):', 'magsy' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['order'] ); ?>" />
		</p>

		<p>
			<input class="checkbox" <?php checked( $instance['random_thumbnails'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'random_thumbnails' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'random_thumbnails' ) ); ?>" type="checkbox">
			<label for="<?php echo esc_attr( $this->get_field_id( 'random_thumbnails' ) ); ?>"><?php esc_html_e( 'Random thumbnails?', 'magsy' ); ?></label>
		</p> <?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['slugs'] = ( ! empty( $new_instance['slugs'] ) ) ? implode( ',', $new_instance['slugs'] ) : '';
		$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
		$instance['random_thumbnails'] = ( ! empty( $new_instance['random_thumbnails'] ) ) ? 1 : 0;

		return $instance;
	}

}