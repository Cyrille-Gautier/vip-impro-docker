<?php

class Magsy_Post_Base_Module extends WP_Widget {

	protected $data;
	protected $excerpt_length;
	protected $enable_category;
	protected $with_query;

	public function __construct( $id_base = '', $name = '', $opts = array(), $with_query = true ) {
		parent::__construct( $id_base, $name, $opts );
		$this->with_query = $with_query;
	}

	public function widget( $args, $instance ) {
		$count = isset( $instance['count'] ) ? $instance['count'] : 5;
		$offset = isset( $instance['offset'] ) ? $instance['offset'] : 0;
		$category = isset( $instance['category'] ) ? $instance['category'] : '';
		$tag = isset( $instance['tag'] ) ? $instance['tag'] : '';
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
		$this->excerpt_length = isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 12;
		$this->enable_category = ! empty( $instance['enable_category'] ) ? 1 : 0;

		$args = array(
			'category_name' => $category,
			'ignore_sticky_posts' => true,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'offset' => $offset,
			'tag' => $tag,
		);

		if ( $orderby == 'like_count' ) {
			$args['meta_key'] = 'magsy_like';
			$args['meta_query'] = array(
				'compare' => '>',
				'key' => 'magsy_like',
				'value' => '0',
			);
			$args['orderby'] = array(
				'meta_value_num' => 'DESC',
				'post_date' => 'DESC',
			);
		} elseif ( $orderby == 'view_count' ) {
			$args['meta_key'] = 'magsy_view';
			$args['meta_query'] = array(
				'compare' => '>',
				'key' => 'magsy_view',
				'value' => '0',
			);
			$args['orderby'] = array(
				'meta_value_num' => 'DESC',
				'post_date' => 'DESC',
			);
		} else {
			$args['orderby'] = $orderby;
		}
		
    $this->data = new WP_Query( $args );
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => '',
			'count' => 5,
			'offset' => 0,
			'category' => '',
			'tag' => '',
			'orderby' => 'date',
			'excerpt_length' => 12,
			'enable_category' => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$categories = get_categories();
		$tags = get_tags();
		$orderby = array(
			array( 'date', esc_html__( 'Date', 'magsy' ) ),
			array( 'rand', esc_html__( 'Randomize', 'magsy' ) ),
			array( 'like_count', esc_html__( 'Like count', 'magsy' ) ),
			array( 'view_count', esc_html__( 'View count', 'magsy' ) ),
			array( 'comment_count', esc_html__( 'Comment count', 'magsy' ) ),
			array( 'modified', esc_html__( 'Last modified date', 'magsy' ) ),
			array( 'title', esc_html__( 'Title', 'magsy' ) ),
			array( 'id', esc_html__( 'Post ID', 'magsy' ) ),
		); ?>

		<?php if ( $this->with_query ) : ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'magsy' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'magsy' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="-1" value="<?php echo esc_attr( $instance['count'] ); ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset:', 'magsy' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" min="0" value="<?php echo esc_attr( $instance['offset'] ); ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category:', 'magsy' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
					<option value="" <?php selected( $instance['category'], '' ); ?>><?php esc_html_e( 'All', 'magsy' ); ?></option>
					<?php foreach ( $categories as $category ) : ?>
						<option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( $instance['category'], $category->slug ); ?>><?php echo esc_html( $category->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php esc_html_e( 'Tag:', 'magsy' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>">
					<option value="" <?php selected( $instance['tag'], '' ); ?>><?php esc_html_e( 'All', 'magsy' ); ?></option>
					<?php foreach ( $tags as $tag ) : ?>
						<option value="<?php echo esc_attr( $tag->slug ); ?>" <?php selected( $instance['tag'], $tag->slug ); ?>><?php echo esc_html( $tag->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order by:', 'magsy' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
					<?php foreach ( $orderby as $o ) : ?>
						<option value="<?php echo esc_attr( $o[0] ); ?>" <?php selected( $instance['orderby'], $o[0] ); ?>><?php echo esc_html( $o[1] ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php esc_html_e( 'Excerpt length:', 'magsy' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" min="0" value="<?php echo esc_attr( $instance['excerpt_length'] ); ?>">
			</p>

			<p>
				<input class="checkbox" <?php checked( $instance['enable_category'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'enable_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'enable_category' ) ); ?>" type="checkbox">
				<label for="<?php echo esc_attr( $this->get_field_id( 'enable_category' ) ); ?>"><?php esc_html_e( 'Show categories?', 'magsy' ); ?></label>
			</p>
		<?php endif; ?>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? intval( strip_tags( $new_instance['count'] ) ) : 0;
		$instance['offset'] = ( ! empty( $new_instance['offset'] ) ) ? intval( strip_tags( $new_instance['offset'] ) ) : 0;
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
		$instance['excerpt_length'] = ( ! empty( $new_instance['excerpt_length'] ) ) ? intval( strip_tags( $new_instance['excerpt_length'] ) ) : 0;
		$instance['enable_category'] = ( ! empty( $new_instance['enable_category'] ) ) ? 1 : 0;

		return $instance;
	}

}